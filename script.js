const messageBar = document.querySelector('.bar-wrapper input');
const sendBtn = document.querySelector('.bar-wrapper button');
const messageBox = document.querySelector('.message-box');

let API_URL = //URL DE TU API;
let API_Key = // API KEY ;

// Función para enviar mensaje
function sendMessage() {
  if (messageBar.value.trim().length > 0) {
    const backgroundText = document.querySelector('.background-text');
    if (backgroundText) backgroundText.style.display = 'none';

    let userMessage = messageBar.value.trim();

    // Mostrar el mensaje del usuario
    let message = `
      <div class="chat message">
        <img src="user.jpg" alt="User">
        <span>${userMessage}</span>
      </div>`;
    messageBox.insertAdjacentHTML('beforeend', message);

    // Limpiar el campo de texto y deshabilitar el botón mientras se procesa
    messageBar.value = '';
    sendBtn.disabled = true;

    // Mostrar respuesta en espera
    let response = `
      <div class="chat response responsive">
        <img src="chatbot.png" alt="ChatBot">
        <span class="new">...</span>
      </div>`;
    messageBox.insertAdjacentHTML('beforeend', response);

    // Opciones para la solicitud a la API
    const requestOptions = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${API_Key}`
      },
      body: JSON.stringify({
        "model": "gpt-3.5-turbo",
        "messages": [{"role": "user", "content": userMessage}]
      })
    };

    // Realizar la solicitud a la API
    fetch(API_URL, requestOptions)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error ${response.status}: ${response.statusText}`);
        }
        return response.json();
      })
      .then(data => {
        const ChatBotResponse = document.querySelector(".responsive .new");
        ChatBotResponse.innerHTML = data.choices[0].message.content || "No response received.";
        ChatBotResponse.classList.remove("new");
      })
      .catch(error => {
        const ChatBotResponse = document.querySelector(".responsive .new");
        ChatBotResponse.innerHTML = "Hubo un error al procesar tu solicitud. Por favor, inténtalo más tarde.";
        console.error("Error:", error);
      })
      .finally(() => {
        // Rehabilitar el botón después de completar la solicitud
        sendBtn.disabled = false;
      });
  }
}

// Configurar eventos
sendBtn.onclick = sendMessage;
messageBar.addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    e.preventDefault();
    sendMessage();
  }
});
