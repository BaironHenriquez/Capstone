<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - TechService Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-auto text-center">
                    <span class="text-tech-dark-blue text-3xl font-bold">TechService Pro</span>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Crear Cuenta
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Regístrate para acceder al sistema
                </p>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST" id="registerForm">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                               placeholder="Ingresa tu nombre completo">
                    </div>
                    <div>
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                               placeholder="Ingresa tu correo electrónico">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="new-password" required 
                                   oninput="checkPasswordStrength()"
                                   class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                                   placeholder="Mínimo 8 caracteres">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg id="eyeOpen" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClosed" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Barra de seguridad -->
                        <div id="passwordStrengthContainer" class="mt-2 hidden">
                            <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                                <div id="passwordStrengthBar" class="h-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p id="passwordStrengthText" class="text-xs mt-1 text-gray-500 font-medium"></p>
                        </div>
                        
                        <!-- Requisitos de contraseña -->
                        <div id="passwordRequirements" class="mt-2 space-y-1 text-xs hidden">
                            <div id="req-length" class="flex items-center text-gray-500">
                                <span class="mr-2">○</span>
                                <span>Mínimo 8 caracteres</span>
                            </div>
                            <div id="req-uppercase" class="flex items-center text-gray-500">
                                <span class="mr-2">○</span>
                                <span>Una letra mayúscula</span>
                            </div>
                            <div id="req-lowercase" class="flex items-center text-gray-500">
                                <span class="mr-2">○</span>
                                <span>Una letra minúscula</span>
                            </div>
                            <div id="req-number" class="flex items-center text-gray-500">
                                <span class="mr-2">○</span>
                                <span>Un número</span>
                            </div>
                            <div id="req-special" class="flex items-center text-gray-500">
                                <span class="mr-2">○</span>
                                <span>Un carácter especial (.;:"#$%&/()=¨]*+@, etc.)</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="password-confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input id="password-confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-tech-electric-blue focus:border-tech-electric-blue sm:text-sm" 
                               placeholder="Confirma tu contraseña">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-tech-electric-blue focus:ring-tech-electric-blue border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        Acepto los <a href="#" class="text-tech-electric-blue hover:text-blue-500">términos y condiciones</a> y la <a href="#" class="text-tech-electric-blue hover:text-blue-500">política de privacidad</a>
                    </label>
                </div>

                <div>
                    <button type="submit" id="submitBtn"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-tech-electric-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tech-electric-blue transition-colors duration-300">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                            </svg>
                        </span>
                        Crear Cuenta
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="font-medium text-tech-electric-blue hover:text-blue-500">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>

                <!-- Demo Access Info -->
                <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                    <h3 class="text-sm font-medium text-green-800 mb-2">✨ Sistema Demo</h3>
                    <p class="text-xs text-green-700 mb-2">Este es un sistema de demostración. Puedes:</p>
                    <ul class="text-xs text-green-600 list-disc list-inside space-y-1">
                        <li>Crear una cuenta demo</li>
                        <li>Usar credenciales de prueba</li>
                        <li>Explorar todas las funcionalidades</li>
                    </ul>
                    <p class="text-xs text-green-600 mt-2">
                        <a href="{{ route('login') }}" class="underline hover:text-green-800">
                            ← Volver al Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });

        // Password strength validation
        const strengthContainer = document.getElementById('passwordStrengthContainer');
        const strengthBar = document.getElementById('passwordStrengthBar');
        const strengthText = document.getElementById('passwordStrengthText');
        const requirements = document.getElementById('passwordRequirements');
        
        const reqLength = document.getElementById('req-length');
        const reqUppercase = document.getElementById('req-uppercase');
        const reqLowercase = document.getElementById('req-lowercase');
        const reqNumber = document.getElementById('req-number');
        const reqSpecial = document.getElementById('req-special');

        passwordInput.addEventListener('focus', function() {
            requirements.classList.remove('hidden');
        });

        // Global function to check password strength
        function checkPasswordStrength() {
            const password = passwordInput.value;
            
            // Reset all requirements
            resetRequirement(reqLength);
            resetRequirement(reqUppercase);
            resetRequirement(reqLowercase);
            resetRequirement(reqNumber);
            resetRequirement(reqSpecial);

            if (password.length === 0) {
                strengthContainer.classList.add('hidden');
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = '';
                strengthText.textContent = '';
                return;
            }

            // Show strength container
            strengthContainer.classList.remove('hidden');

            // Check requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[.;:"#$%&/()=¨\[\]*+@,!¡?¿\-_{}|\\<>~`^]/.test(password);

            // Update visual indicators
            if (hasLength) markRequirementMet(reqLength);
            if (hasUppercase) markRequirementMet(reqUppercase);
            if (hasLowercase) markRequirementMet(reqLowercase);
            if (hasNumber) markRequirementMet(reqNumber);
            if (hasSpecial) markRequirementMet(reqSpecial);

            // Count critical requirements (uppercase, number, special character)
            let criticalScore = 0;
            if (hasUppercase) criticalScore++;
            if (hasNumber) criticalScore++;
            if (hasSpecial) criticalScore++;

            // Update strength bar based on 3 levels
            if (criticalScore === 0 || criticalScore === 1) {
                // ROJO - Insegura (0-1 requisitos)
                strengthBar.style.width = '33%';
                strengthBar.style.backgroundColor = '#ef4444'; // red
                strengthText.textContent = '🔴 Contraseña insegura';
                strengthText.className = 'text-xs mt-1 text-red-600 font-medium';
                
                if (!hasUppercase && !hasNumber && !hasSpecial) {
                    strengthText.textContent = '🔴 Debe contener mayúscula, número y carácter especial';
                } else if (!hasUppercase) {
                    strengthText.textContent = '🔴 Debe contener una mayúscula';
                } else if (!hasNumber) {
                    strengthText.textContent = '🔴 Debe contener un número';
                } else if (!hasSpecial) {
                    strengthText.textContent = '🔴 Debe contener un carácter especial (.;:"#$%&/()=¨]*+@, etc.)';
                }
            } else if (criticalScore === 2) {
                // AMARILLO - Regular (2 requisitos)
                strengthBar.style.width = '66%';
                strengthBar.style.backgroundColor = '#eab308'; // yellow
                strengthText.textContent = '🟡 Contraseña regular';
                strengthText.className = 'text-xs mt-1 text-yellow-600 font-medium';
                
                if (!hasUppercase) {
                    strengthText.textContent = '🟡 Agrégale una mayúscula para mayor seguridad';
                } else if (!hasNumber) {
                    strengthText.textContent = '🟡 Agrégale un número para mayor seguridad';
                } else if (!hasSpecial) {
                    strengthText.textContent = '🟡 Agrégale un carácter especial para mayor seguridad';
                }
            } else {
                // VERDE - Segura (3 requisitos)
                strengthBar.style.width = '100%';
                strengthBar.style.backgroundColor = '#22c55e'; // green
                strengthText.textContent = '✅ Contraseña segura';
                strengthText.className = 'text-xs mt-1 text-green-600 font-medium';
            }
        }

        function resetRequirement(element) {
            element.classList.remove('text-green-600');
            element.classList.add('text-gray-500');
            element.querySelector('span:first-child').textContent = '○';
        }

        function markRequirementMet(element) {
            element.classList.remove('text-gray-500');
            element.classList.add('text-green-600');
            element.querySelector('span:first-child').textContent = '✓';
        }

        // Form validation before submit
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');

        registerForm.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            
            // Check critical requirements
            const hasUppercase = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[.;:"#$%&\/()=¨\[\]*+@,!¡?¿\-_{}|\\<>~`^]/.test(password);
            
            if (!hasUppercase || !hasNumber || !hasSpecial) {
                e.preventDefault();
                
                // Show error message
                let errorMsg = 'La contraseña debe contener: ';
                let missing = [];
                if (!hasUppercase) missing.push('una mayúscula');
                if (!hasNumber) missing.push('un número');
                if (!hasSpecial) missing.push('un carácter especial');
                
                errorMsg += missing.join(', ');
                
                // Create or update error message
                let errorDiv = document.getElementById('password-error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.id = 'password-error-message';
                    errorDiv.className = 'mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg';
                    passwordInput.closest('.space-y-4').appendChild(errorDiv);
                }
                
                errorDiv.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-red-800 font-medium">${errorMsg}</p>
                    </div>
                `;
                
                // Scroll to error
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                return false;
            }
            
            // Remove error message if exists
            const errorDiv = document.getElementById('password-error-message');
            if (errorDiv) {
                errorDiv.remove();
            }
        });

        // Password confirmation validation
        const passwordConfirmation = document.getElementById('password-confirmation');
        
        passwordConfirmation.addEventListener('input', function() {
            if (this.value === passwordInput.value && this.value !== '') {
                this.style.borderColor = '#22c55e';
            } else if (this.value !== '') {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#d1d5db';
            }
        });
    </script>

</body>
</html>