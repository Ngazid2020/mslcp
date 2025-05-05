<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratoire d'Analyses Médicales</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/custom/remixicon.min.css')}}">
    @livewireStyles
    @livewireScripts
    @filamentStyles
    @filamentScripts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* ! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com */*,:before,:after{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / .5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }*,:before,:after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}:before,:after{--tw-content: ""}html,:host{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:Figtree,ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}ol,ul,menu{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::-moz-placeholder,textarea::-moz-placeholder{opacity:1;color:#9ca3af}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}button,[role=button]{cursor:pointer}:disabled{cursor:default}img,svg,video,canvas,audio,iframe,embed,object{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.absolute{position:absolute}.relative{position:relative}.-bottom-16{bottom:-4rem}.-left-16{left:-4rem}.-left-20{left:-5rem}.top-0{top:0}.z-0{z-index:0}.\!row-span-1{grid-row:span 1 / span 1!important}.-mx-3{margin-left:-.75rem;margin-right:-.75rem}.-ml-px{margin-left:-1px}.ml-3{margin-left:.75rem}.mt-4{margin-top:1rem}.mt-6{margin-top:1.5rem}.flex{display:flex}.inline-flex{display:inline-flex}.table{display:table}.grid{display:grid}.\!hidden{display:none!important}.hidden{display:none}.aspect-video{aspect-ratio:16 / 9}.size-12{width:3rem;height:3rem}.size-5{width:1.25rem;height:1.25rem}.size-6{width:1.5rem;height:1.5rem}.h-12{height:3rem}.h-40{height:10rem}.h-5{height:1.25rem}.h-full{height:100%}.min-h-screen{min-height:100vh}.w-5{width:1.25rem}.w-\[calc\(100\%_\+_8rem\)\]{width:calc(100% + 8rem)}.w-auto{width:auto}.w-full{width:100%}.max-w-2xl{max-width:42rem}.max-w-\[877px\]{max-width:877px}.flex-1{flex:1 1 0%}.shrink-0{flex-shrink:0}.transform{transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.cursor-default{cursor:default}.resize{resize:both}.grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}.\!flex-row{flex-direction:row!important}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.items-stretch{align-items:stretch}.justify-end{justify-content:flex-end}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.justify-items-center{justify-items:center}.gap-2{gap:.5rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.self-center{align-self:center}.overflow-hidden{overflow:hidden}.rounded-\[10px\]{border-radius:10px}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:.5rem}.rounded-md{border-radius:.375rem}.rounded-sm{border-radius:.125rem}.rounded-l-md{border-top-left-radius:.375rem;border-bottom-left-radius:.375rem}.rounded-r-md{border-top-right-radius:.375rem;border-bottom-right-radius:.375rem}.border{border-width:1px}.border-gray-300{--tw-border-opacity: 1;border-color:rgb(209 213 219 / var(--tw-border-opacity, 1))}.bg-\[\#FF2D20\]\/10{background-color:#ff2d201a}.bg-gray-50{--tw-bg-opacity: 1;background-color:rgb(249 250 251 / var(--tw-bg-opacity, 1))}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity, 1))}.bg-gradient-to-b{background-image:linear-gradient(to bottom,var(--tw-gradient-stops))}.from-transparent{--tw-gradient-from: transparent var(--tw-gradient-from-position);--tw-gradient-to: rgb(0 0 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)}.via-white{--tw-gradient-to: rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops: var(--tw-gradient-from), #fff var(--tw-gradient-via-position), var(--tw-gradient-to)}.to-white{--tw-gradient-to: #fff var(--tw-gradient-to-position)}.to-zinc-900{--tw-gradient-to: #18181b var(--tw-gradient-to-position)}.stroke-\[\#FF2D20\]{stroke:#ff2d20}.object-cover{-o-object-fit:cover;object-fit:cover}.object-top{-o-object-position:top;object-position:top}.p-6{padding:1.5rem}.px-2{padding-left:.5rem;padding-right:.5rem}.px-3{padding-left:.75rem;padding-right:.75rem}.px-4{padding-left:1rem;padding-right:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.py-10{padding-top:2.5rem;padding-bottom:2.5rem}.py-16{padding-top:4rem;padding-bottom:4rem}.py-2{padding-top:.5rem;padding-bottom:.5rem}.pt-3{padding-top:.75rem}.text-center{text-align:center}.font-sans{font-family:Figtree,ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji"}.text-sm{font-size:.875rem;line-height:1.25rem}.text-sm\/relaxed{font-size:.875rem;line-height:1.625}.text-xl{font-size:1.25rem;line-height:1.75rem}.font-medium{font-weight:500}.font-semibold{font-weight:600}.leading-5{line-height:1.25rem}.text-black{--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity, 1))}.text-black\/50{color:#00000080}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity, 1))}.text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.underline{text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-\[0px_14px_34px_0px_rgba\(0\,0\,0\,0\.08\)\]{--tw-shadow: 0px 14px 34px 0px rgba(0,0,0,.08);--tw-shadow-colored: 0px 14px 34px 0px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.shadow-sm{--tw-shadow: 0 1px 2px 0 rgb(0 0 0 / .05);--tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.ring-1{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}.ring-black{--tw-ring-opacity: 1;--tw-ring-color: rgb(0 0 0 / var(--tw-ring-opacity, 1))}.ring-gray-300{--tw-ring-opacity: 1;--tw-ring-color: rgb(209 213 219 / var(--tw-ring-opacity, 1))}.ring-transparent{--tw-ring-color: transparent}.ring-white{--tw-ring-opacity: 1;--tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity, 1))}.ring-white\/\[0\.05\]{--tw-ring-color: rgb(255 255 255 / .05)}.drop-shadow-\[0px_4px_34px_rgba\(0\,0\,0\,0\.06\)\]{--tw-drop-shadow: drop-shadow(0px 4px 34px rgba(0,0,0,.06));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.drop-shadow-\[0px_4px_34px_rgba\(0\,0\,0\,0\.25\)\]{--tw-drop-shadow: drop-shadow(0px 4px 34px rgba(0,0,0,.25));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.filter{filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.transition{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,-webkit-backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter,-webkit-backdrop-filter;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.duration-150{transition-duration:.15s}.duration-300{transition-duration:.3s}.ease-in-out{transition-timing-function:cubic-bezier(.4,0,.2,1)}.selection\:bg-\[\#FF2D20\] *::-moz-selection{--tw-bg-opacity: 1;background-color:rgb(255 45 32 / var(--tw-bg-opacity, 1))}.selection\:bg-\[\#FF2D20\] *::selection{--tw-bg-opacity: 1;background-color:rgb(255 45 32 / var(--tw-bg-opacity, 1))}.selection\:text-white *::-moz-selection{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.selection\:text-white *::selection{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.selection\:bg-\[\#FF2D20\]::-moz-selection{--tw-bg-opacity: 1;background-color:rgb(255 45 32 / var(--tw-bg-opacity, 1))}.selection\:bg-\[\#FF2D20\]::selection{--tw-bg-opacity: 1;background-color:rgb(255 45 32 / var(--tw-bg-opacity, 1))}.selection\:text-white::-moz-selection{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.selection\:text-white::selection{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.hover\:text-black:hover{--tw-text-opacity: 1;color:rgb(0 0 0 / var(--tw-text-opacity, 1))}.hover\:text-black\/70:hover{color:#000000b3}.hover\:text-gray-400:hover{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity, 1))}.hover\:text-gray-500:hover{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.hover\:ring-black\/20:hover{--tw-ring-color: rgb(0 0 0 / .2)}.focus\:z-10:focus{z-index:10}.focus\:border-blue-300:focus{--tw-border-opacity: 1;border-color:rgb(147 197 253 / var(--tw-border-opacity, 1))}.focus\:outline-none:focus{outline:2px solid transparent;outline-offset:2px}.focus\:ring:focus{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}.focus-visible\:ring-1:focus-visible{--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000)}.focus-visible\:ring-\[\#FF2D20\]:focus-visible{--tw-ring-opacity: 1;--tw-ring-color: rgb(255 45 32 / var(--tw-ring-opacity, 1))}.active\:bg-gray-100:active{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity, 1))}.active\:text-gray-500:active{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity, 1))}.active\:text-gray-700:active{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity, 1))}@media (min-width: 640px){.sm\:flex{display:flex}.sm\:hidden{display:none}.sm\:size-16{width:4rem;height:4rem}.sm\:size-6{width:1.5rem;height:1.5rem}.sm\:flex-1{flex:1 1 0%}.sm\:items-center{align-items:center}.sm\:justify-between{justify-content:space-between}.sm\:pt-5{padding-top:1.25rem}}@media (min-width: 768px){.md\:row-span-3{grid-row:span 3 / span 3}}@media (min-width: 1024px){.lg\:col-start-2{grid-column-start:2}.lg\:h-16{height:4rem}.lg\:max-w-7xl{max-width:80rem}.lg\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}.lg\:grid-cols-3{grid-template-columns:repeat(3,minmax(0,1fr))}.lg\:flex-col{flex-direction:column}.lg\:items-end{align-items:flex-end}.lg\:justify-center{justify-content:center}.lg\:gap-8{gap:2rem}.lg\:p-10{padding:2.5rem}.lg\:pb-10{padding-bottom:2.5rem}.lg\:pt-0{padding-top:0}.lg\:text-\[\#FF2D20\]{--tw-text-opacity: 1;color:rgb(255 45 32 / var(--tw-text-opacity, 1))}}.rtl\:flex-row-reverse:where([dir=rtl],[dir=rtl] *){flex-direction:row-reverse}@media (prefers-color-scheme: dark){.dark\:block{display:block}.dark\:hidden{display:none}.dark\:border-gray-600{--tw-border-opacity: 1;border-color:rgb(75 85 99 / var(--tw-border-opacity, 1))}.dark\:bg-black{--tw-bg-opacity: 1;background-color:rgb(0 0 0 / var(--tw-bg-opacity, 1))}.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity, 1))}.dark\:bg-zinc-900{--tw-bg-opacity: 1;background-color:rgb(24 24 27 / var(--tw-bg-opacity, 1))}.dark\:via-zinc-900{--tw-gradient-to: rgb(24 24 27 / 0) var(--tw-gradient-to-position);--tw-gradient-stops: var(--tw-gradient-from), #18181b var(--tw-gradient-via-position), var(--tw-gradient-to)}.dark\:to-zinc-900{--tw-gradient-to: #18181b var(--tw-gradient-to-position)}.dark\:text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity, 1))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity, 1))}.dark\:text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity, 1))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.dark\:text-white\/50{color:#ffffff80}.dark\:text-white\/70{color:#ffffffb3}.dark\:ring-zinc-800{--tw-ring-opacity: 1;--tw-ring-color: rgb(39 39 42 / var(--tw-ring-opacity, 1))}.dark\:hover\:text-gray-300:hover{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity, 1))}.dark\:hover\:text-white:hover{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity, 1))}.dark\:hover\:text-white\/70:hover{color:#ffffffb3}.dark\:hover\:text-white\/80:hover{color:#fffc}.dark\:hover\:ring-zinc-700:hover{--tw-ring-opacity: 1;--tw-ring-color: rgb(63 63 70 / var(--tw-ring-opacity, 1))}.dark\:focus\:border-blue-700:focus{--tw-border-opacity: 1;border-color:rgb(29 78 216 / var(--tw-border-opacity, 1))}.dark\:focus\:border-blue-800:focus{--tw-border-opacity: 1;border-color:rgb(30 64 175 / var(--tw-border-opacity, 1))}.dark\:focus-visible\:ring-\[\#FF2D20\]:focus-visible{--tw-ring-opacity: 1;--tw-ring-color: rgb(255 45 32 / var(--tw-ring-opacity, 1))}.dark\:focus-visible\:ring-white:focus-visible{--tw-ring-opacity: 1;--tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity, 1))}.dark\:active\:bg-gray-700:active{--tw-bg-opacity: 1;background-color:rgb(55 65 81 / var(--tw-bg-opacity, 1))}.dark\:active\:text-gray-300:active{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity, 1))}}
            </style>
        @endif
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        
        body {
            font-family: 'Montserrat', sans-serif;
            scroll-behavior: smooth;
        }
        
        .hero-section {
            background-position: center;
            background-size: cover;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 50%, rgba(255,255,255,0) 100%);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .btn-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }
        
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .service-card:hover .service-icon {
            transform: rotate(10deg);
        }
        
        .service-icon {
            transition: transform 0.5s ease;
        }
        
        .news-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .social-icon {
            transition: transform 0.3s ease, color 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-3px);
            color: #3b82f6;
        }
        
        input:focus, textarea:focus {
            animation: focusAnimation 0.3s ease forwards;
        }
        
        @keyframes focusAnimation {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .badge {
            transition: transform 0.3s ease;
            transform-style: preserve-3d;
        }
        
        .badge:hover {
            transform: perspective(500px) rotateY(10deg);
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .slide-in-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .slide-in-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .visible {
            opacity: 1;
            transform: translate(0);
        }
        
        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            
            .fade-in, .slide-in-left, .slide-in-right {
                opacity: 1;
                transform: translate(0);
                transition: none;
            }
        }
        
        .custom-checkbox {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }
        
        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        
        .checkmark {
            height: 20px;
            width: 20px;
            background-color: #fff;
            border: 2px solid #ddd;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .custom-checkbox input:checked ~ .checkmark {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 7px;
            top: 3px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }
    </style>
        
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm fixed w-full top-0 z-50 opacity-0 animate-[fadeIn_0.8s_ease_forwards]">
        <div class="container mx-auto px-36 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="/" class="font-['Pacifico'] text-2xl text-primary">
                    <img src="{{ asset('img/logo.png') }}">
                </a>
            </div>
            
            <nav class="hidden md:flex space-x-8">
                <a href="#services" class="nav-link text-gray-700 font-medium hover:text-primary transition-colors">Services</a>
                <a href="#info" class="nav-link text-gray-700 font-medium hover:text-primary transition-colors">Informations</a>
                <a href="#actualites" class="nav-link text-gray-700 font-medium hover:text-primary transition-colors">Actualités</a>
                <a href="#contact" class="nav-link text-gray-700 font-medium hover:text-primary transition-colors">Contact</a>
            </nav>
            
            <div>
                <a href="/admin" class="btn-pulse bg-primary text-white px-5 py-2 !rounded-button font-medium hover:bg-blue-600 transition-all shadow-md whitespace-nowrap flex items-center">
                    <div class="w-5 h-5 flex items-center justify-center mr-2">
                    @svg('heroicon-o-user')
                    </div>
                    Espace Laboratoire
                </a>
            </div>
            
            <div class="md:hidden w-8 h-8 flex items-center justify-center cursor-pointer">
                <i class="ri-menu-line text-xl"></i>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section min-h-[600px] flex items-center pt-24" style="background-image: url('http://mslcp.local/img/bg-img.jpg');">
        <div class="container mx-auto px-36 py-16">
            <div class="hero-content max-w-2xl slide-in-left">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Votre santé mérite la meilleure analyse</h1>
                <p class="text-lg text-gray-600 mb-8">Laboratoire d'analyses médicales de pointe avec des résultats rapides et fiables. Notre équipe de professionnels est à votre service pour tous vos besoins en matière de santé.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#rendez-vous" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-blue-600 transition-all shadow-md whitespace-nowrap flex items-center justify-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-2">
                        @svg('heroicon-o-calendar-days')
                        </div>
                        Prendre rendez-vous
                    </a>
                    <a href="#resultats" class="bg-white text-primary border border-primary px-6 py-3 !rounded-button font-medium hover:bg-gray-50 transition-all shadow-sm whitespace-nowrap flex items-center justify-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-2">
                        @svg('heroicon-o-queue-list')
                        </div>
                        Consulter mes résultats
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-white">
        <div class="container mx-auto px-36">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Nos Services</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Découvrez notre gamme complète d'analyses médicales réalisées par nos experts qualifiés avec des équipements de dernière génération.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="service-card bg-white p-6 rounded-lg shadow-md border border-gray-100 fade-in">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 service-icon">
                        <!-- <i class="ri-test-tube-line text-primary text-2xl"></i> -->
                        @svg('heroicon-o-beaker','w-5 h-5 text-primary')
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Analyses Sanguines</h3>
                    <p class="text-gray-600 mb-4">Hémogramme, glycémie, cholestérol, bilan hépatique, ionogramme et plus de 200 paramètres analysables.</p>
                    <a href="#" class="text-primary font-medium flex items-center hover:underline">
                        En savoir plus
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            @svg('heroicon-o-arrow-right')
                        </div>
                    </a>
                </div>
                
                <div class="service-card bg-white p-6 rounded-lg shadow-md border border-gray-100 fade-in">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 service-icon">
                        <!-- <i class="ri-microscope-line text-primary text-2xl"></i> -->
                        @svg('heroicon-o-eye-dropper','w-5 h-5 text-primary')
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Microbiologie</h3>
                    <p class="text-gray-600 mb-4">Analyses bactériologiques, mycologiques et parasitologiques pour identifier les agents pathogènes.</p>
                    <a href="#" class="text-primary font-medium flex items-center hover:underline">
                        En savoir plus
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                        @svg('heroicon-o-arrow-right')
                        </div>
                    </a>
                </div>
                
                <div class="service-card bg-white p-6 rounded-lg shadow-md border border-gray-100 fade-in">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 service-icon">
                        @svg('heroicon-o-heart','w-5 h-5 text-primary')
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Cardiologie</h3>
                    <p class="text-gray-600 mb-4">Électrocardiogrammes, tests d'effort et analyses spécifiques pour la santé cardiovasculaire.</p>
                    <a href="#" class="text-primary font-medium flex items-center hover:underline">
                        En savoir plus
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            @svg('heroicon-o-arrow-right')
                        </div>
                    </a>
                </div>
                
                <div class="service-card bg-white p-6 rounded-lg shadow-md border border-gray-100 fade-in">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 service-icon">
                        <!-- <i class="ri-virus-line text-primary text-2xl"></i> -->
                        @svg('heroicon-o-bug-ant','w-5 h-5 text-primary')
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Immunologie</h3>
                    <p class="text-gray-600 mb-4">Dépistage des allergies, maladies auto-immunes et évaluation du système immunitaire.</p>
                    <a href="#" class="text-primary font-medium flex items-center hover:underline">
                        En savoir plus
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            @svg('heroicon-o-arrow-right')
                        </div>
                    </a>
                </div>
                
                <div class="service-card bg-white p-6 rounded-lg shadow-md border border-gray-100 fade-in">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 service-icon">
                        <!-- <i class="ri-women-line text-primary text-2xl"></i> -->
                        @svg('heroicon-o-funnel','w-5 h-5 text-primary')
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Gynécologie</h3>
                    <p class="text-gray-600 mb-4">Frottis, tests hormonaux, dépistage prénatal et suivi de grossesse personnalisé.</p>
                    <a href="#" class="text-primary font-medium flex items-center hover:underline">
                        En savoir plus
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            @svg('heroicon-o-arrow-right')
                        </div>
                    </a>
                </div>
                
                <!-- <div class="service-card bg-white p-6 rounded-lg shadow-md border border-gray-100 fade-in">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 service-icon">
                        <i class="ri-home-heart-line text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Prélèvements à Domicile</h3>
                    <p class="text-gray-600 mb-4">Service de prélèvement à domicile pour les personnes à mobilité réduite ou les cas particuliers.</p>
                    <a href="#" class="text-primary font-medium flex items-center hover:underline">
                        En savoir plus
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                    </a>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section id="info" class="py-16 bg-gray-50">
        <div class="container mx-auto px-36">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Informations Pratiques</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Tout ce que vous devez savoir pour votre visite dans notre laboratoire.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-6 h-6 flex items-center justify-center mr-2 text-primary">
                            <i class="ri-time-line"></i>
                        </div>
                        Horaires d'ouverture
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between">
                            <span class="text-gray-600">Lundi - Vendredi</span>
                            <span class="font-medium">7h30 - 18h30</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Samedi</span>
                            <span class="font-medium">8h00 - 12h30</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Dimanche</span>
                            <span class="font-medium">Fermé</span>
                        </li>
                    </ul>
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <h4 class="font-medium text-gray-800 mb-2">Note importante:</h4>
                        <p class="text-gray-600 text-sm">Pour les analyses à jeun, les prélèvements sont prioritaires jusqu'à 10h00.</p>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-6 h-6 flex items-center justify-center mr-2 text-primary">
                        @svg('heroicon-o-map-pin')
                        </div>
                        Nos Adresses
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-800">Laboratoire MSLCP</h4>
                            <p class="text-gray-600">Moroni, Coulée de Lave</p>
                            <p class="text-gray-600">Tél: 333 03 27</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Centre Médical Rive Gauche</h4>
                            <p class="text-gray-600">8 Rue de la Santé, 75005 Paris</p>
                            <p class="text-gray-600">Tél: 01 45 67 89 11</p>
                        </div>
                    </div>
                    <div class="mt-4 h-40 bg-gray-100 rounded overflow-hidden" style="background-image: url('https://public.readdy.ai/gen_page/map_placeholder_1280x720.png'); background-position: center; background-size: cover;"></div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="w-6 h-6 flex items-center justify-center mr-2 text-primary">
                        @svg('heroicon-o-information-circle')                        
                        </div>
                        Chiffres Clés
                    </h3>
                    <div class="space-y-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary counter">25</div>
                            <p class="text-gray-600">Années d'expérience</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary counter">45000</div>
                            <p class="text-gray-600">Patients par an</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary counter">98</div>
                            <p class="text-gray-600">% de satisfaction</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary counter">24</div>
                            <p class="text-gray-600">Heures pour les résultats</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- <div class="mt-12 bg-white p-6 rounded-lg shadow-md fade-in">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Évolution de notre activité</h3>
                <div id="chart" class="w-full h-80"></div>
            </div> -->
        </div>
    </section>

    <!-- News Section -->
    <section id="actualites" class="py-16 bg-white">
        <div class="container mx-auto px-36">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Actualités et Conseils Santé</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Restez informé des dernières nouvelles du laboratoire et découvrez nos conseils pour prendre soin de votre santé.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card bg-white rounded-lg shadow-md overflow-hidden fade-in">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('img/firmbee-c.jpg') }}" alt="Nouvelle technologie" class="w-full h-full object-cover object-top transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <div class="w-4 h-4 flex items-center justify-center mr-1">
                                <i class="ri-calendar-line"></i>
                            </div>
                            28 avril 2025
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Nouvelle technologie d'analyse sanguine</h3>
                        <p class="text-gray-600 mb-4">Notre laboratoire vient d'acquérir un équipement de pointe permettant des analyses plus rapides et plus précises pour le dépistage précoce de certaines pathologies.</p>
                        <a href="#" class="text-primary font-medium flex items-center hover:underline">
                            Lire la suite
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-arrow-right-line"></i>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="news-card bg-white rounded-lg shadow-md overflow-hidden fade-in">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('img/firmbee-c.jpg') }}" alt="Prévention santé" class="w-full h-full object-cover object-top transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <div class="w-4 h-4 flex items-center justify-center mr-1">
                                <i class="ri-calendar-line"></i>
                            </div>
                            25 avril 2025
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Les bilans de prévention à ne pas négliger</h3>
                        <p class="text-gray-600 mb-4">Découvrez quels examens réaliser régulièrement selon votre âge et vos antécédents pour une prévention efficace des problèmes de santé.</p>
                        <a href="#" class="text-primary font-medium flex items-center hover:underline">
                            Lire la suite
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-arrow-right-line"></i>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="news-card bg-white rounded-lg shadow-md overflow-hidden fade-in">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('img/firmbee-c.jpg') }}" alt="Préparation analyses" class="w-full h-full object-cover object-top transition-transform duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <div class="w-4 h-4 flex items-center justify-center mr-1">
                                <i class="ri-calendar-line"></i>
                            </div>
                            20 avril 2025
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Comment bien se préparer pour vos analyses</h3>
                        <p class="text-gray-600 mb-4">Conseils pratiques pour préparer au mieux votre visite au laboratoire et garantir des résultats fiables pour vos analyses médicales.</p>
                        <a href="#" class="text-primary font-medium flex items-center hover:underline">
                            Lire la suite
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-arrow-right-line"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-10 fade-in">
                <a href="#" class="inline-block bg-white text-primary border border-primary px-6 py-3 !rounded-button font-medium hover:bg-gray-50 transition-all shadow-sm whitespace-nowrap">
                    Voir toutes les actualités
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-36">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Ce que disent nos patients</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Découvrez les témoignages de nos patients satisfaits de la qualité de nos services.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                    <div class="flex items-center text-yellow-400 mb-4">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"Personnel très professionnel et attentionné. Les résultats sont disponibles rapidement en ligne et le laboratoire est toujours propre et bien organisé."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="ri-user-line text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Sophie Dupont</h4>
                            <p class="text-sm text-gray-500">Patiente depuis 2022</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                    <div class="flex items-center text-yellow-400 mb-4">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"J'apprécie particulièrement le service de prélèvement à domicile qui m'a été très utile pendant ma convalescence. Équipe médicale compétente et aimable."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="ri-user-line text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Jean-Pierre Martin</h4>
                            <p class="text-sm text-gray-500">Patient depuis 2020</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md fade-in">
                    <div class="flex items-center text-yellow-400 mb-4">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-half-fill"></i>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"Laboratoire moderne avec des équipements de pointe. J'apprécie la rapidité des résultats et les explications claires fournies par les biologistes quand j'ai des questions."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="ri-user-line text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Marie Leclerc</h4>
                            <p class="text-sm text-gray-500">Patiente depuis 2023</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 flex flex-wrap justify-center gap-6 fade-in">
                <div class="badge bg-white p-4 rounded-lg shadow-sm flex items-center">
                    <div class="w-8 h-8 flex items-center justify-center mr-2">
                        <i class="ri-award-fill text-2xl text-blue-500"></i>
                    </div>
                    <span class="font-medium text-gray-800">Certifié ISO 9001</span>
                </div>
                
                <div class="badge bg-white p-4 rounded-lg shadow-sm flex items-center">
                    <div class="w-8 h-8 flex items-center justify-center mr-2">
                        <i class="ri-shield-check-fill text-2xl text-green-500"></i>
                    </div>
                    <span class="font-medium text-gray-800">Accrédité COFRAC</span>
                </div>
                
                <div class="badge bg-white p-4 rounded-lg shadow-sm flex items-center">
                    <div class="w-8 h-8 flex items-center justify-center mr-2">
                        <i class="ri-heart-fill text-2xl text-red-500"></i>
                    </div>
                    <span class="font-medium text-gray-800">Partenaire Santé</span>
                </div>
                
                <div class="badge bg-white p-4 rounded-lg shadow-sm flex items-center">
                    <div class="w-8 h-8 flex items-center justify-center mr-2">
                        <i class="ri-hospital-fill text-2xl text-purple-500"></i>
                    </div>
                    <span class="font-medium text-gray-800">Réseau Hospitalier</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-36">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Contactez-nous</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Une question ? Besoin d'informations supplémentaires ? Notre équipe est à votre disposition.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="fade-in">
                    <form id="contact-form" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Votre nom">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Votre email">
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Sujet de votre message">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Votre message"></textarea>
                        </div>
                        
                        <div class="flex items-start">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="privacy">
                                <span class="checkmark mr-2"></span>
                                <span class="text-sm text-gray-600">J'accepte la politique de confidentialité et le traitement de mes données personnelles</span>
                            </label>
                        </div>
                        
                        <div>
                            <button type="submit" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-blue-600 transition-all shadow-md whitespace-nowrap w-full md:w-auto">
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="space-y-8 fade-in">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informations de contact</h3>
                        <div class="space-y-4">
                            <div class="flex">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="ri-phone-line text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Téléphone</h4>
                                    <p class="text-gray-600">01 45 67 89 10</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="ri-mail-line text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Email</h4>
                                    <p class="text-gray-600">contact@laboratoire-analyses.fr</p>
                                </div>
                            </div>
                            
                            <div class="flex">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="ri-map-pin-line text-primary"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Adresse principale</h4>
                                    <p class="text-gray-600">15 Avenue des Sciences, 75008 Paris</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Questions fréquentes</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-800">Faut-il prendre rendez-vous ?</h4>
                                <p class="text-gray-600 text-sm">Pour la plupart des analyses, vous pouvez venir sans rendez-vous. Certains examens spécifiques nécessitent une réservation préalable.</p>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-800">Comment accéder à mes résultats ?</h4>
                                <p class="text-gray-600 text-sm">Vos résultats sont disponibles sur notre espace patient sécurisé, par email ou directement au laboratoire sur présentation d'une pièce d'identité.</p>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-800">Les analyses sont-elles remboursées ?</h4>
                                <p class="text-gray-600 text-sm">La plupart des analyses sont prises en charge par l'Assurance Maladie sur prescription médicale. Nous pratiquons le tiers-payant.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="fade-in">
                    <a href="#" class="font-['Pacifico'] text-2xl text-white mb-4 inline-block">logo</a>
                    <p class="text-gray-300 mb-6">Votre laboratoire d'analyses médicales de confiance depuis 2000. Expertise, innovation et proximité au service de votre santé.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center social-icon">
                            <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center social-icon">
                            <i class="ri-twitter-fill"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center social-icon">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center social-icon">
                            <i class="ri-instagram-fill"></i>
                        </a>
                    </div>
                </div>
                
                <div class="fade-in">
                    <h3 class="text-lg font-semibold mb-4">Liens Rapides</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="#services" class="text-gray-300 hover:text-white transition-colors">Nos Services</a></li>
                        <li><a href="#info" class="text-gray-300 hover:text-white transition-colors">Informations Pratiques</a></li>
                        <li><a href="#actualites" class="text-gray-300 hover:text-white transition-colors">Actualités</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Espace Patient</a></li>
                    </ul>
                </div>
                
                <div class="fade-in">
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Analyses Sanguines</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Microbiologie</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Cardiologie</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Immunologie</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Gynécologie</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Prélèvements à Domicile</a></li>
                    </ul>
                </div>
                
                <div class="fade-in">
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-300 mb-4">Abonnez-vous pour recevoir nos actualités et conseils santé.</p>
                    <form class="space-y-4">
                        <div>
                            <input type="email" placeholder="Votre email" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-white">
                        </div>
                        <button type="submit" class="bg-primary text-white px-4 py-2 !rounded-button font-medium hover:bg-blue-600 transition-all whitespace-nowrap w-full">S'abonner</button>
                    </form>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-700 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    © 2025 Laboratoire d'Analyses Médicales. Tous droits réservés.
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 text-sm hover:text-white transition-colors">Politique de confidentialité</a>
                    <a href="#" class="text-gray-400 text-sm hover:text-white transition-colors">Mentions légales</a>
                    <a href="#" class="text-gray-400 text-sm hover:text-white transition-colors">CGU</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Header animation
            const header = document.querySelector('header');
            setTimeout(() => {
                header.style.opacity = '1';
            }, 300);
            
            // Intersection Observer for fade-in animations
            const fadeElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right');
            
            const fadeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        fadeObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
            
            fadeElements.forEach(element => {
                fadeObserver.observe(element);
            });
            
            // Counter animation
            const counters = document.querySelectorAll('.counter');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(entry.target.innerText);
                        let count = 0;
                        const duration = 2000; // 2 seconds
                        const increment = target / (duration / 16);
                        
                        const updateCount = () => {
                            count += increment;
                            if (count < target) {
                                entry.target.innerText = Math.floor(count);
                                requestAnimationFrame(updateCount);
                            } else {
                                entry.target.innerText = target;
                            }
                        };
                        
                        requestAnimationFrame(updateCount);
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });
            
            counters.forEach(counter => {
                counterObserver.observe(counter);
            });
            
            // Contact form validation
            const contactForm = document.getElementById('contact-form');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Simple validation
                    let valid = true;
                    const name = document.getElementById('name');
                    const email = document.getElementById('email');
                    const message = document.getElementById('message');
                    
                    if (!name.value.trim()) {
                        valid = false;
                        name.classList.add('border-red-500');
                    } else {
                        name.classList.remove('border-red-500');
                    }
                    
                    if (!email.value.trim() || !email.value.includes('@')) {
                        valid = false;
                        email.classList.add('border-red-500');
                    } else {
                        email.classList.remove('border-red-500');
                    }
                    
                    if (!message.value.trim()) {
                        valid = false;
                        message.classList.add('border-red-500');
                    } else {
                        message.classList.remove('border-red-500');
                    }
                    
                    if (valid) {
                        // Here you would normally send the form data to a server
                        alert('Votre message a été envoyé avec succès !');
                        contactForm.reset();
                    }
                });
            }
            
            // Initialize chart
            
        });
    </script>
</body>
</html>