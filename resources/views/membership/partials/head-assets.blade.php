<script src="https://cdn.tailwindcss.com"></script>
@if($isRtl)
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
@else
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Source+Serif+4:ital,opsz,wght@0,8..60,400..700;1,8..60,400..700&display=swap" rel="stylesheet">
@endif
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .login-card-shadow {
        box-shadow: 0 20px 50px -12px rgba(4, 22, 46, 0.15);
    }
    body { font-family: {{ $isRtl ? "'Cairo', sans-serif" : "'Plus Jakarta Sans', sans-serif" }}; }
    .font-headline { font-family: {{ $isRtl ? "'Cairo', sans-serif" : "'Source Serif 4', serif" }}; }
</style>
<script id="tailwind-config">
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#04162e',
                    'primary-container': '#1a2b44',
                    secondary: '#735c00',
                    'secondary-container': '#fed65b',
                    background: '#fbf9f4',
                    'on-background': '#1b1c19',
                    'on-surface-variant': '#44474d',
                    'surface-container-low': '#f5f3ee',
                    'surface-container-lowest': '#ffffff',
                    'surface-container-high': '#eae8e3',
                    'outline-variant': '#c5c6ce',
                },
            },
        },
    }
</script>
