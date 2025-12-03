<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServicioTecnico;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->jerarquia >= 4) {
            return redirect()->route('super-admin.dashboard');
        }

        return view('super-admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Credenciales incorrectas.']);
        }

        if (!$user->role || $user->role->jerarquia < 4) {
            return back()->withErrors(['email' => 'No tienes permisos de Super Administrador.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credenciales incorrectas.']);
        }

        Auth::login($user);

        return redirect()->route('super-admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('super-admin.login');
    }

    public function dashboard()
    {
        $totalServicios = ServicioTecnico::count();
        $suscripcionesActivas = Subscription::where('status', 'active')->count();
        $totalUsuarios = User::whereHas('role', function($q) {
            $q->where('nombre_rol', 'Administrador');
        })->count();

        $ingresosCompletados = Payment::where('status', 'completed')
            ->sum('amount');

        $pagosPendientes = Payment::where('status', 'pending')->count();

        $distribucionPagos = Payment::where('status', 'completed')
            ->select('payment_method', DB::raw('COUNT(*) as total'), DB::raw('SUM(amount) as monto_total'))
            ->groupBy('payment_method')
            ->get();

        $conversionRate = $totalUsuarios > 0 
            ? round(($suscripcionesActivas / $totalUsuarios) * 100, 2) 
            : 0;

        $serviciosActivos = ServicioTecnico::where('activo', true)->count();
        $nuevosMesActual = ServicioTecnico::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $ticketPromedioPago = Payment::where('status', 'completed')
            ->avg('amount');

        $crecimientoMensual = ServicioTecnico::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $ingresosMensuales = Payment::where('status', 'completed')
            ->select(
                DB::raw('MONTH(paid_at) as mes'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('paid_at', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $distribucionPlanes = Subscription::where('status', 'active')
            ->select('plan_type', DB::raw('COUNT(*) as total'))
            ->groupBy('plan_type')
            ->get();

        $tasaRetencion = Subscription::where('status', 'active')
            ->whereYear('created_at', '<', now()->year)
            ->count();
        $totalAnteriores = Subscription::whereYear('created_at', '<', now()->year)->count();
        $retencionPorcentaje = $totalAnteriores > 0 
            ? round(($tasaRetencion / $totalAnteriores) * 100, 1) 
            : 0;

        $suscripcionesExpiran = Subscription::where('status', 'active')
            ->whereBetween('ends_at', [now(), now()->addDays(30)])
            ->count();

        return view('super-admin.dashboard', compact(
            'totalServicios',
            'suscripcionesActivas',
            'totalUsuarios',
            'ingresosCompletados',
            'pagosPendientes',
            'distribucionPagos',
            'conversionRate',
            'serviciosActivos',
            'nuevosMesActual',
            'ticketPromedioPago',
            'crecimientoMensual',
            'ingresosMensuales',
            'distribucionPlanes',
            'retencionPorcentaje',
            'suscripcionesExpiran'
        ));
    }

    public function serviciosTecnicos(Request $request)
    {
        $query = ServicioTecnico::with(['user.subscriptions' => function($q) {
            $q->latest();
        }, 'user.payments']);

        if ($request->has('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre_servicio', 'like', "%{$buscar}%")
                  ->orWhere('rut', 'like', "%{$buscar}%")
                  ->orWhere('correo', 'like', "%{$buscar}%");
            });
        }

        $servicios = $query->paginate(20);

        return view('super-admin.servicios-tecnicos', compact('servicios'));
    }

    public function reporteFinanciero(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        $ingresosMensuales = Payment::where('status', 'completed')
            ->whereYear('paid_at', $year)
            ->select(
                DB::raw('MONTH(paid_at) as mes'),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $suscripcionesActivas = Subscription::where('status', 'active')
            ->where('ends_at', '>', now())
            ->get();

        $mrr = $suscripcionesActivas->sum(function($sub) {
            return match($sub->plan_type) {
                'monthly' => $sub->amount,
                'quarterly' => $sub->amount / 3,
                'yearly' => $sub->amount / 12,
                default => 0
            };
        });

        $totalSuscripciones = Subscription::whereYear('created_at', $year)->count();
        $cancelaciones = Subscription::where('status', 'cancelled')
            ->whereYear('cancelled_at', $year)
            ->count();
        
        $churnRate = $totalSuscripciones > 0 
            ? round(($cancelaciones / $totalSuscripciones) * 100, 2) 
            : 0;

        $distribucionPlanes = Subscription::where('status', 'active')
            ->select('plan_type', DB::raw('COUNT(*) as total'))
            ->groupBy('plan_type')
            ->get();

        return view('super-admin.reporte-financiero', compact(
            'ingresosMensuales',
            'mrr',
            'churnRate',
            'distribucionPlanes',
            'year'
        ));
    }

    public function alertas()
    {
        $suscripcionesPorVencer = Subscription::where('status', 'active')
            ->whereBetween('ends_at', [now(), now()->addDays(30)])
            ->with('user.servicioTecnico')
            ->orderBy('ends_at')
            ->get();

        $pagosFallidos = Payment::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(3))
            ->with('user.servicioTecnico')
            ->orderBy('created_at', 'desc')
            ->get();

        $pruebasGratuitasPorExpirar = User::whereHas('role', function($q) {
                $q->where('nombre_rol', 'Administrador');
            })
            ->whereNotNull('trial_ends_at')
            ->whereBetween('trial_ends_at', [now(), now()->addDays(7)])
            ->whereDoesntHave('subscriptions', function($q) {
                $q->where('status', 'active');
            })
            ->with('servicioTecnico')
            ->get();

        $cancelacionesRecientes = Subscription::where('status', 'cancelled')
            ->where('cancelled_at', '>=', now()->subDays(7))
            ->with('user.servicioTecnico')
            ->orderBy('cancelled_at', 'desc')
            ->get();

        return view('super-admin.alertas', compact(
            'suscripcionesPorVencer',
            'pagosFallidos',
            'pruebasGratuitasPorExpirar',
            'cancelacionesRecientes'
        ));
    }
}
