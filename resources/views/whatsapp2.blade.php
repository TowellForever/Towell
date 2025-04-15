@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 max-w-2xl">
    <h1 class="text-2xl font-bold text-center mb-6">Reportar Falla</h1>
    <form action="/send-whatsapp2" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        <!-- Telar -->
        <div class="flex items-center gap-2">
            <label class="w-28 text-base font-semibold text-gray-800">Telar:</label>
            <select name="telar" class="flex-1 p-1 border border-gray-300 rounded text-sm" required>
                @for ($i = 207; $i <= 230; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Tipo -->
        <div class="flex items-center gap-2">
            <label class="w-28 text-base font-semibold text-gray-800">Tipo:</label>
            <select name="tipo" id="tipo" class="flex-1 p-1 border border-gray-300 rounded text-sm" required>
                <option value="">Selecciona tipo</option>
                <option value="mecanica">Mecánica</option>
                <option value="electrica">Eléctrica</option>
            </select>
        </div>

        <!-- Clave Falla -->
        <div class="flex items-center gap-2">
            <label class="w-28 text-base font-semibold text-gray-800">Clave:</label>
            <select name="clave_falla" id="clave_falla" class="flex-1 p-1 border border-gray-300 rounded text-sm" required>
                <option value="">Selecciona clave</option>
            </select>
        </div>

        <!-- Descripción -->
        <div class="flex items-center gap-2">
            <label class="w-28 text-base font-semibold text-gray-800">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" class="flex-1 p-1 border border-gray-300 rounded text-sm bg-gray-100" readonly required>
        </div>

        <!-- Fecha -->
        <div class="flex items-center gap-2">
            <label class="w-28 text-base font-semibold text-gray-800">Fecha:</label>
            <input type="date" id="fecha_reporte" name="fecha_reporte" class="flex-1 p-1 border border-gray-300 rounded text-sm" required>
        </div>

        <!-- Hora -->
        <div class="flex items-center gap-2">
            <label class="w-28 text-base font-semibold text-gray-800">Hora:</label>
            <input type="time" id="hora_reporte" name="hora_reporte" class="flex-1 p-1 border border-gray-300 rounded text-sm" required>
        </div>

        <!-- Operador -->
        <div class="flex items-center gap-2">
            <label class="w-28 text-base font-semibold text-gray-800">Operador:</label>
            <input type="text" name="operador" class="flex-1 p-1 border border-gray-300 rounded text-sm" value="{{ Auth::User()->nombre }}">

        </div>

        <!-- Observaciones -->
        <div class="md:col-span-2 flex items-start gap-2">
            <label class="w-28 text-base font-semibold text-gray-800 pt-1">Observaciones:</label>
            <textarea name="observaciones" rows="3" class="flex-1 p-1 border border-gray-300 rounded text-sm"></textarea>
        </div>

        <!-- Botón -->
        <div class="md:col-span-2 text-center mt-4 flex justify-center gap-4">
            <!-- WhatsApp -->
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded">
                Enviar por WhatsApp
            </button>

            <!-- Enviar por SMS -->
            <button type="button" id="btnEnviarSms" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Enviar por SMS
            </button>
        </div>

    </form>
</div>

<script>
    document.getElementById('btnEnviarSms').addEventListener('click', function () {
        const form = document.querySelector('form');
        const data = new FormData(form);
    
                const mensaje = `
        🚨 *REPORTE DE FALLA* 🚨
        📅 Fecha: ${data.get('fecha_reporte')}
        ⏰ Hora: ${data.get('hora_reporte')}
        🧵 Telar: ${data.get('telar')}
        ⚙️ Tipo: ${data.get('tipo')}
        🔐 Clave: ${data.get('clave_falla')}
        📝 Descripción: ${data.get('descripcion')}
        👤 Operador: ${data.get('operador')}
        🗒️ Observaciones: ${data.get('observaciones') || 'N/A'}
            `;
    
        fetch('/send-failSMS', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                telefono: '+522214125380', // ← Cambia por el número destino real
                mensaje: mensaje
            })
        }).then(res => res.json())
          .then(data => {
              alert('SMS enviado exitosamente ✅');
          }).catch(err => {
              console.error(err);
              alert('Error al enviar SMS ❌');
          });
    });
    </script>
    

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tipoSelect = document.getElementById('tipo');
        const claveSelect = document.getElementById('clave_falla');
        const descripcionInput = document.getElementById('descripcion');

        // Todos los datos de fallas están embebidos desde backend (como JSON)
        const fallas = @json($fallas);

        tipoSelect.addEventListener('change', function () {
            const tipo = this.value;
            claveSelect.innerHTML = '<option value="">Selecciona clave</option>';
            descripcionInput.value = '';

            const filtradas = fallas.filter(f => f.tipo === tipo);
            filtradas.forEach(f => {
                const option = document.createElement('option');
                option.value = f.clave;
                option.textContent = f.clave;
                option.dataset.descripcion = f.descripcion;
                claveSelect.appendChild(option);
            });
        });

        claveSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            descripcionInput.value = selected.dataset.descripcion || '';
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fecha = new Date();

        // Formatear fecha (YYYY-MM-DD)
        const fechaFormateada = fecha.toISOString().split('T')[0];
        document.getElementById('fecha_reporte').value = fechaFormateada;

        // Formatear hora (HH:MM)
        const horaFormateada = fecha.toTimeString().slice(0, 5);
        document.getElementById('hora_reporte').value = horaFormateada;
    });
</script>

@endsection
