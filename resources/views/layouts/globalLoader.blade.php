<!-- resources/views/partials/globalLoader.blade.php -->
<div id="globalLoader" class="glass-card loading fixed inset-0 z-50 flex justify-center items-center">
    <div class="loader">
        <div></div>
    </div>
</div>

<style>
    /* Estilo para el loader */

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .loader {
        width: 50px;
        height: 50px;
        border: 4px solid #fff;
        border-top: 4px solid #2563eb;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .glass-card.loading form {
        opacity: 0.4;
        pointer-events: none;
    }

    .glass-card.loading .loader {
        display: block;
    }

    /* Estilo para ocultar el loader */
    #globalLoader.hidden {
        display: none;
    }
</style>
