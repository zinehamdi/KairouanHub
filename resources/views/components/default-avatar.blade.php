@props([
    'size' => 'md',
    'name' => null,
    'class' => '',
])

@php
    $sizeClasses = [
        'xs' => 'w-8 h-8',
        'sm' => 'w-10 h-10', 
        'md' => 'w-14 h-14',
        'lg' => 'w-20 h-20',
        'xl' => 'w-24 h-24',
        '2xl' => 'w-32 h-32',
        '3xl' => 'w-40 h-40',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $initials = $name ? mb_strtoupper(mb_substr($name, 0, 1)) : null;
@endphp

<div {{ $attributes->merge(['class' => "$sizeClass rounded-full overflow-hidden $class"]) }}>
    <svg viewBox="0 0 100 100" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
        {{-- Metallic Gold Gradient Background --}}
        <defs>
            <linearGradient id="avatarGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#D4AF37;stop-opacity:1" />
                <stop offset="50%" style="stop-color:#E8B545;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#B87333;stop-opacity:1" />
            </linearGradient>
            <linearGradient id="personGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:#FFFFFF;stop-opacity:0.95" />
                <stop offset="100%" style="stop-color:#F5F1E8;stop-opacity:0.9" />
            </linearGradient>
            {{-- Decorative pattern --}}
            <pattern id="avatarPattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/>
            </pattern>
        </defs>
        
        {{-- Background circle with gradient --}}
        <circle cx="50" cy="50" r="50" fill="url(#avatarGradient)"/>
        
        {{-- Subtle pattern overlay --}}
        <circle cx="50" cy="50" r="50" fill="url(#avatarPattern)" opacity="0.3"/>
        
        {{-- Inner glow ring --}}
        <circle cx="50" cy="50" r="46" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
        
        @if($initials)
            {{-- Show initials if name provided --}}
            <text x="50" y="50" 
                  text-anchor="middle" 
                  dominant-baseline="central"
                  fill="white"
                  font-family="Tajawal, system-ui, sans-serif"
                  font-weight="700"
                  font-size="38"
                  style="text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                {{ $initials }}
            </text>
        @else
            {{-- Friendly person silhouette --}}
            <g transform="translate(50, 50)">
                {{-- Head --}}
                <circle cx="0" cy="-12" r="14" fill="url(#personGradient)"/>
                
                {{-- Body/Shoulders with curved shape --}}
                <path d="M-22 28 Q-22 8 0 8 Q22 8 22 28 L22 35 L-22 35 Z" 
                      fill="url(#personGradient)"/>
                
                {{-- Subtle smile suggestion on body (like a friendly wave hint) --}}
                <ellipse cx="0" cy="22" rx="8" ry="3" fill="rgba(212,175,55,0.15)"/>
            </g>
        @endif
        
        {{-- Decorative corner sparkle --}}
        <g transform="translate(78, 22)" opacity="0.6">
            <path d="M0 -6 L1.5 -1.5 L6 0 L1.5 1.5 L0 6 L-1.5 1.5 L-6 0 L-1.5 -1.5 Z" 
                  fill="white"/>
        </g>
    </svg>
</div>
