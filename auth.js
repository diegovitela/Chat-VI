import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-auth.js";

// Configuración de Firebase
const firebaseConfig = {
    apiKey: "AIzaSyCQsyqrndSjmt_4-Ar9TPqyl0fuI9RPcLM",
    authDomain: "chat-70095.firebaseapp.com",
    projectId: "chat-70095",
    storageBucket: "chat-70095.appspot.com",
    messagingSenderId: "1002196903757",
    appId: "1:1002196903757:web:7dc2386cb3c883a563b904",
    measurementId: "G-5LT3Y03WRN"
};

// Inicializar Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth();
const provider = new GoogleAuthProvider();

// Manejar el clic en el botón de inicio de sesión
document.getElementById('login-google').addEventListener('click', () => {
    signInWithPopup(auth, provider)
        .then((result) => {
            const user = result.user;
            console.log("Usuario autenticado:", user);
            alert(`¡Bienvenido, ${user.displayName}!`);
            // Redirigir a la página principal
            window.location.href = "pagina2.html";
        })
        .catch((error) => {
            console.error("Error en el inicio de sesión:", error);
            alert("Hubo un error al iniciar sesión. Por favor, inténtalo nuevamente.");
        });
});
