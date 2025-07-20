<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    {{ __('Profile Settings') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manage your account information and security preferences</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Last updated: {{ $user->updated_at->format('M d, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Overview Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 mb-8 border border-blue-100">
                <div class="flex items-center gap-6">
                    <!-- Profile Image Upload -->
                    <div class="relative group">
                        <div class="relative">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/default-avatar.jpg') }}" 
                            alt="User Image" 
                            width="100" 
                            height="100"
                            onerror="this.onerror=null;this.src='{{ asset('images/team/avatar-doctor.png') }}';"
                            alt="Profile Photo"
                                 class="h-24 w-24 rounded-2xl object-cover border-3 border-white shadow-lg transition-all duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="text-center">
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</h1>
                        <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                Active Account
                            </span>
                          
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Main Profile Form -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Profile Information Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 style="margin-bottom: 8px; font-weight: 600; font-size: 1.125rem; color: #1a202c;">Personal Information</h3>
                                    <p style="font-size: 0.875rem; color: #718096;">Update your basic account details</p>
                                </div>
                                
                            </div>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="p-8 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="name" :value="__('Full Name')" class="text-sm font-medium text-gray-700 mb-2" />
                                    <x-text-input id="name" name="name" type="text" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Phone Number')" class="text-sm font-medium text-gray-700 mb-2" />
                                    <x-text-input id="phone" name="phone" type="tel" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                        :value="old('phone', $user->phone)" required autocomplete="tel" />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email Address')" class="text-sm font-medium text-gray-700 mb-2" />
                                <x-text-input id="email" name="email" type="email" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                    :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                           
                            </div>

                            <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                        Save Changes
                                    </button>
                                    
                                    @if (session('status') === 'profile-updated')
                                        <div id="profile-success-message" class="flex items-center gap-2 text-sm text-green-600 bg-green-50 px-4 py-2 rounded-lg">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Profile updated successfully
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Password Update Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 mb-2">Security Settings</h3>
                                    <p class="text-sm text-gray-600">Update your password to keep your account secure</p>
                                </div>
                                
                            </div>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="p-8 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-medium text-gray-700 mb-2" />
                                <x-text-input id="update_password_current_password" name="current_password" type="password" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" 
                                    autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-medium text-gray-700 mb-2" />
                                    <x-text-input id="update_password_password" name="password" type="password" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" 
                                        autocomplete="new-password" />
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="text-sm font-medium text-gray-700 mb-2" />
                                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" 
                                        autocomplete="new-password" />
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                        Update Password
                                    </button>
                                    
                                    @if (session('status') === 'password-updated')
                                        <div id="password-success-message" class="flex items-center gap-2 text-sm text-green-600 bg-green-50 px-4 py-2 rounded-lg">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Password updated successfully
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Account Status -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Account Status</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Profile Completion</span>
                                <span class="text-sm font-medium text-green-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Member since</span>
                                <span class="font-medium">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L2.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-red-900">Danger Zone</h4>
                        </div>
                        <p class="text-sm text-red-700 mb-4">
                            Permanently delete your account and all associated data. This action cannot be undone.
                        </p>
                        <button id="delete-account-btn"
                            class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-3">
                @csrf
                @method('delete')

                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L2.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Delete Account</h2>
                    <p class="text-gray-600">Are you absolutely sure you want to delete your account?</p>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-red-800">
                        <strong>Warning:</strong> This action is permanent and cannot be undone. All your data, including medical records, appointments, and personal information will be permanently deleted.
                    </p>
                </div>

                <div class="mb-6">
                    <x-input-label for="delete_password" value="Enter your password to confirm" class="text-sm font-medium text-gray-700 mb-2" />
                    <x-text-input id="delete_password" name="password" type="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Password" required />
                    @if($errors->userDeletion->has('password'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="flex gap-4">
                    <button type="button" id="cancel-delete-btn"
                        class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Verification Form (Hidden) -->
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: none;">
            @csrf
        </form>
    @endif

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Delete account modal functionality
            $('#delete-account-btn').on('click', function(e) {
                e.preventDefault();
                $('#delete-modal').removeClass('hidden');
                $('body').addClass('overflow-hidden'); // Prevent scrolling
            });

            $('#cancel-delete-btn').on('click', function(e) {
                e.preventDefault();
                $('#delete-modal').addClass('hidden');
                $('body').removeClass('overflow-hidden');
                $('#delete_password').val(''); // Clear password field
            });

            // Close modal when clicking outside
            $('#delete-modal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                    $('body').removeClass('overflow-hidden');
                    $('#delete_password').val('');
                }
            });

            // Auto-hide success messages
            setTimeout(function() {
                $('#profile-success-message').fadeOut();
                $('#password-success-message').fadeOut();
            }, 4000);

            // Show modal if there are deletion errors
            @if($errors->userDeletion->isNotEmpty())
                $('#delete-modal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            @endif
        });
    </script>
</x-app-layout>