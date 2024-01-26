// Espera a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener("DOMContentLoaded", () => {
    // Obtiene el elemento del DOM con el ID "subirArriba" y lo almacena en la variable subir
    const subir = document.getElementById("subirArriba");

    // Define una función llamada toggleScrollButtonVisibility que alterna la clase "hidden" en el botón según la posición de desplazamiento vertical
    const toggleScrollButtonVisibility = () => {
        // Agrega o quita la clase "hidden" en función de si el desplazamiento vertical es menor o igual a 200
        subir.classList.toggle("hidden", window.scrollY <= 400);
    };

    // Agrega un evento de escucha para el evento de desplazamiento en la ventana. Cuando ocurre un desplazamiento, se llama a toggleScrollButtonVisibility.
    window.addEventListener("scroll", toggleScrollButtonVisibility);

    // Agrega un evento de clic al botón. Cuando se hace clic en el botón, se ejecuta una función que hace que la ventana se desplace suavemente hacia la parte superior.
    subir.addEventListener("click", () => {
        // Desplaza la ventana hacia la parte superior con un efecto suave
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
});
