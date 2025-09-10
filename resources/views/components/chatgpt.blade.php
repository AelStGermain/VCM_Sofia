<div class="container py-4">
    <div class="card shadow-lg mx-auto" style="max-width: 700px;">
        <div class="card-header text-white text-center" style="background-color: #061a36;">
            <h4 class="mb-0"><i class="bi bi-robot me-2"></i>Asistente de Ayuda</h4>
        </div>
        <div class="card-body">
            <div id="chat-history" style="max-height: 350px; overflow-y: auto; margin-bottom: 1rem; background: #f8f9fa; border-radius: 8px; padding: 1rem;">
                <!-- Aquí se mostrarán los mensajes del chat -->
            </div>
            <form id="chatgpt-form">
                <div class="mb-3">
                    <label for="prompt" class="form-label">¿En qué puedo ayudarte?</label>
                    <textarea class="form-control" id="prompt" name="prompt" rows="2" placeholder="Escribe tu pregunta aquí..." required></textarea>
                </div>
                <button type="submit" class="btn w-100" style="background-color: #061a36; color: #fff;">
                    <i class="bi bi-send"></i> Enviar
                </button>
            </form>
        </div>
    </div>
</div>
<script>
let chatHistory = [];

function renderChat() {
    const chatDiv = document.getElementById('chat-history');
    chatDiv.innerHTML = '';
    chatHistory.forEach(msg => {
        chatDiv.innerHTML += `
            <div style="margin-bottom: 1rem;">
                <div style="font-weight: bold; color: #061a36;">Tú:</div>
                <div style="background: #e9ecef; border-radius: 6px; padding: 0.5rem;">${msg.question}</div>
                <div style="font-weight: bold; color: #0A2342; margin-top:0.5rem;">Asistente:</div>
                <div style="background: #d1e7dd; border-radius: 6px; padding: 0.5rem;">${msg.answer}</div>
            </div>
        `;
    });
    chatDiv.scrollTop = chatDiv.scrollHeight;
}

document.getElementById('chatgpt-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const prompt = document.getElementById('prompt').value;
    const chatDiv = document.getElementById('chat-history');

    // Muestra la pregunta en el historial
    chatHistory.push({ question: prompt, answer: '<span class="text-muted">Consultando...</span>' });
    renderChat();

    fetch('{{ route("chatgpt.ask") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ prompt })
    })
    .then(res => res.json())
    .then(data => {
        let answer = '';
        if(data.choices && data.choices[0]) {
            answer = data.choices[0].message.content;
        } else if(data.error) {
            answer = '<span class="text-danger">' + data.error + '</span>';
        } else {
            answer = '<span class="text-danger">No se pudo obtener respuesta.</span>';
        }
        // Actualiza la última respuesta en el historial
        chatHistory[chatHistory.length - 1].answer = answer;
        renderChat();
    })
    .catch(() => {
        chatHistory[chatHistory.length - 1].answer = '<span class="text-danger">Error al consultar el asistente.</span>';
        renderChat();
    });

    document.getElementById('prompt').value = '';
});
</script>