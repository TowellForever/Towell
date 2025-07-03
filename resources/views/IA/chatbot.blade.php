<!-- resources/views/chatbot.blade.php -->
@extends('layouts.app')
@section('content')
    <div class="flex justify-center max-w-5xl mx-auto mt-8 w-full">
        <!-- Imagen a la izquierda -->
        <div class="flex items-center justify-center w-1/5">
            <img src="{{ asset('images/robot_for_chatbot.png') }}" alt="Chatbot"
                class="w-32 h-32 object-contain rounded-full shadow-lg" />
        </div>
        <!-- Contenedor del chat (derecha) -->
        <div id="chat-container" class="w-4/5 pl-6">
            <div id="chat-box" class="bg-white rounded-lg p-4 h-96 overflow-y-scroll border"></div>
            <form id="chat-form" class="flex mt-4">
                <input id="user-input" class="flex-1 border p-2 rounded-l" type="text"
                    placeholder="Escribe tu mensaje..." autocomplete="off">
                <button class="bg-blue-500 text-white p-2 rounded-r w-[120px]" type="submit">Enviar</button>
            </form>
        </div>
    </div>
    <script>
        // public/js/chatbot.js
        $(document).ready(function() {
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                let userMessage = $('#user-input').val();
                $('#chat-box').append('<div class="text-right mb-2"><b>Tú:</b> ' + userMessage + '</div>');
                $('#user-input').val('');

                $.post('/chatbot/message', {
                    message: userMessage,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(data) {
                    $('#chat-box').append(
                        '<div class="text-left mb-2"><b>Towellin:</b> ' + data
                        .message + '</div>');
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                });
            });
        });
    </script>
@endsection
