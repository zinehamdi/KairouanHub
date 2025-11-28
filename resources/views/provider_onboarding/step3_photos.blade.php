@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-cover bg-center bg-fixed py-12" style="background-image: linear-gradient(135deg, rgba(0, 188, 212, 0.25), rgba(0, 150, 136, 0.30), rgba(76, 175, 80, 0.20)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-flash />
        
        <!-- Wizard Progress Header with Vibrant Colors -->
        <div class="mb-10">
            <div class="flex items-center justify-center space-x-4">
                <!-- Step 1 - Completed with Green Checkmark -->
                <div class="flex items-center transform transition-all hover:scale-105">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-green-400 via-emerald-500 to-green-600 text-white font-bold shadow-2xl border-4 border-white">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="ml-3 text-base font-bold text-green-700">Basic Info</span>
                </div>
                <div class="flex-1 h-2 bg-gradient-to-r from-green-400 to-purple-400 max-w-[120px] rounded-full shadow-inner"></div>
                
                <!-- Step 2 - Completed with Purple Checkmark -->
                <div class="flex items-center transform transition-all hover:scale-105">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 via-indigo-500 to-purple-600 text-white font-bold shadow-2xl border-4 border-white">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="ml-3 text-base font-bold text-purple-700">Services</span>
                </div>
                <div class="flex-1 h-2 bg-gradient-to-r from-purple-400 via-teal-300 to-cyan-400 max-w-[120px] rounded-full shadow-inner"></div>
                
                <!-- Step 3 - Active with Cyan Animation -->
                <div class="flex items-center transform transition-all hover:scale-110">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-400 to-teal-500 rounded-full blur-xl opacity-60 animate-pulse"></div>
                        <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-cyan-500 via-teal-600 to-cyan-700 text-white font-bold text-xl shadow-2xl border-4 border-white">
                            3
                        </div>
                    </div>
                    <span class="ml-3 text-base font-extrabold bg-gradient-to-r from-cyan-600 to-teal-700 bg-clip-text text-transparent">Photos</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="relative bg-gradient-to-br from-white via-cyan-50 to-teal-50 backdrop-blur-lg rounded-3xl shadow-2xl border-4 border-white/50 overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-gradient-to-br from-cyan-300/30 to-transparent rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-gradient-to-tr from-teal-300/30 to-transparent rounded-full blur-3xl"></div>
            
            <!-- Card Header -->
            <div class="relative bg-gradient-to-r from-cyan-600 via-teal-600 to-cyan-700 px-10 py-10 overflow-hidden">
                <div class="absolute inset-0 opacity-30">
                    <div class="absolute inset-0 animate-pulse" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 15px, rgba(255,255,255,0.15) 15px, rgba(255,255,255,0.15) 30px);"></div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/30 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h1 class="text-4xl font-extrabold text-white drop-shadow-2xl">{{ __('onboarding.step3.title') }}</h1>
                    </div>
                    <p class="text-white/95 text-lg font-medium">Upload photos of your work to showcase your services 📸</p>
                </div>
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('provider.photos.store') }}" enctype="multipart/form-data" class="relative z-10 p-10 space-y-7">
                @csrf
                
                <div class="space-y-7">
                    <!-- File Upload Area with Rainbow Border -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 via-teal-500 to-green-500 rounded-3xl blur-lg opacity-40 group-hover:opacity-75 transition duration-1000"></div>
                        <div class="relative border-4 border-dashed border-cyan-400 rounded-3xl p-14 text-center bg-gradient-to-br from-cyan-50/80 via-white to-teal-50/80 backdrop-blur-sm hover:border-teal-500 hover:bg-gradient-to-br hover:from-cyan-100/80 hover:to-teal-100/80 transition-all duration-500 cursor-pointer">
                            <div class="mb-6">
                                <div class="relative inline-block">
                                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-400 to-teal-600 rounded-full blur-2xl opacity-50 animate-pulse"></div>
                                    <svg class="relative w-24 h-24 mx-auto text-transparent bg-gradient-to-br from-cyan-500 to-teal-600" fill="currentColor" stroke="white" stroke-width="1" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <label for="photos" class="cursor-pointer block">
                                <span class="inline-block px-10 py-5 bg-gradient-to-r from-cyan-500 via-teal-600 to-cyan-700 text-white font-extrabold text-xl rounded-2xl shadow-2xl hover:shadow-cyan-500/50 hover:scale-110 transition-all duration-300 border-4 border-white">
                                    📂 Choose Photos
                                </span>
                                <input type="file" id="photos" name="photos[]" multiple accept="image/*" class="hidden" onchange="updateFileList(this)" />
                            </label>
                            <p class="mt-6 text-lg font-bold text-gray-800">
                                Upload up to <span class="text-2xl font-extrabold bg-gradient-to-r from-cyan-600 to-teal-700 bg-clip-text text-transparent">{{ $max }}</span> high-quality images 🖼️
                            </p>
                            <p class="mt-3 text-base font-medium text-gray-600">
                                All image formats supported • Auto-optimized to WebP • Max 10MB each
                            </p>
                        </div>
                    </div>

                    <!-- Selected Files Preview -->
                    <div id="fileList" class="hidden">
                        <h3 class="text-2xl font-extrabold bg-gradient-to-r from-cyan-600 to-teal-700 bg-clip-text text-transparent mb-4">Selected Files:</h3>
                        <div id="fileListContent" class="space-y-3"></div>
                    </div>
                </div>

                <!-- Form Actions with Vibrant Buttons -->
                <div class="mt-10 flex items-center justify-between pt-8 border-t-4 border-gradient-to-r from-cyan-400 to-teal-500">
                    <a href="{{ route('provider.services') }}" class="group px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-gray-300">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </span>
                    </a>
                    <div class="flex gap-3">
                        <a href="{{ route('provider.dashboard') }}" class="group px-8 py-4 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <span class="flex items-center">
                                Skip for Now
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </a>
                        <button type="submit" onclick="return validatePhotos()" class="group relative px-12 py-5 bg-gradient-to-r from-cyan-600 via-teal-600 to-green-600 text-white font-extrabold text-xl rounded-2xl shadow-2xl hover:shadow-cyan-500/50 hover:scale-110 transition-all duration-300 overflow-hidden">
                            <span class="relative z-10 flex items-center">
                                {{ __('onboarding.buttons.upload') }} & Complete 🎉
                                <svg class="w-6 h-6 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-cyan-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help Text with Colorful Icon -->
        <div class="mt-8 bg-gradient-to-r from-cyan-50 to-teal-50 rounded-3xl p-7 border-4 border-cyan-200 shadow-xl">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-teal-600 flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-xl font-extrabold bg-gradient-to-r from-cyan-700 to-teal-800 bg-clip-text text-transparent mb-3">Photo Tips for Best Results:</h4>
                    <ul class="text-base text-gray-700 space-y-2">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2 text-xl">✓</span>
                            <span class="font-medium">Use clear, well-lit photos of your completed work</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2 text-xl">✓</span>
                            <span class="font-medium">Show before and after results when possible</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2 text-xl">✓</span>
                            <span class="font-medium">Avoid blurry or low-quality images</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-orange-500 mr-2 text-xl">✓</span>
                            <span class="font-medium">Include close-up details and wide shots</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileList(input) {
    const fileList = document.getElementById('fileList');
    const fileListContent = document.getElementById('fileListContent');
    
    if (input.files.length > 0) {
        fileList.classList.remove('hidden');
        fileListContent.innerHTML = '';
        
        Array.from(input.files).forEach((file, index) => {
            const colors = ['from-red-400 to-pink-500', 'from-blue-400 to-cyan-500', 'from-green-400 to-emerald-500', 'from-purple-400 to-indigo-500', 'from-orange-400 to-amber-500'];
            const color = colors[index % colors.length];
            
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-5 bg-gradient-to-r ' + color + ' rounded-2xl shadow-lg transform hover:scale-105 transition-all';
            fileItem.innerHTML = `
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-white/30 backdrop-blur-sm flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-lg">${file.name}</span>
                </div>
                <span class="text-white/90 font-semibold text-base px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
            `;
            fileListContent.appendChild(fileItem);
        });
    } else {
        fileList.classList.add('hidden');
    }
}

function validatePhotos() {
    const fileInput = document.getElementById('photos');
    if (!fileInput.files || fileInput.files.length === 0) {
        if (confirm('⚠️ No photos selected!\n\nYou haven\'t selected any photos to upload. Click "OK" to continue without photos, or "Cancel" to select photos first.')) {
            return true;
        }
        return false;
    }
    return true;
}
</script>
@endsection
