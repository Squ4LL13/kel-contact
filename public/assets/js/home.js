/**
 * Permet de créer la liste de lettres
 */
const letterElements = document.querySelectorAll(".letter-title");
const createLettersBlock = () => {
    const lettersContainer = document.querySelector(
        ".anchor-letters-container"
    );

    letterElements.forEach((element) => {
        const letterLink = document.createElement("a");
        letterLink.innerText = element.innerText;
        letterLink.setAttribute("href", `#${element.innerText}`);
        lettersContainer.appendChild(letterLink);
    });
};
createLettersBlock();

/**
 * Permet de supprimer les parenthèses vides
 */
const allSpan = document.querySelectorAll("span");
allSpan.forEach((span) => {
    if (span.textContent.includes("()")) {
        span.innerText = "";
    }
});

/**
 * Ajouter un espace entre 2 chiffres dans les numéros de téléphone
 */
const phoneRegExp = /^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/;
/*
0123456789
01 23 45 67 89
01.23.45.67.89
0123 45.67.89
0033 123-456-789
+33-1.23.45.67.89
+33 - 123 456 789
+33(0) 123 456 789
+33 (0)123 45 67 89
+33 (0)1 2345-6789
+33(0) - 123456789
*/


// const swalWithCustomButtons = Swal.mixin({
//     customClass: {
//         confirmButton: "delete-button-success",
//         cancelButton: "delete-button-cancel",
//     },
//     buttonsStyling: false,
// });

// if (document.querySelector("form.delete-form")) {
//     const deleteForm = document.querySelector("form.delete-form");
//     deleteForm.addEventListener("submit", (e) => {
//         e.preventDefault();
//         swalWithCustomButtons
//             .fire({
//                 title: "Êtes-vous sûr ?",
//                 text: "Vous êtes sur le point de supprimer un contact !",
//                 icon: "error",
//                 showCancelButton: true,
//                 confirmButtonText: "Oui, le supprimer",
//                 cancelButtonText: "Non, annuler",
//                 reverseButtons: true,
//             })
//             .then((result) => {
//                 if (result.isConfirmed) {
//                     swalWithCustomButtons.fire(
//                         "Supprimé !",
//                         "Le contact a bien été supprimé !",
//                         "success"
//                     );
//                     window.location.href = deleteForm.getAttribute('href');
//                 } else if (
//                     /* Read more about handling dismissals below */
//                     result.dismiss === Swal.DismissReason.cancel
//                 ) {
//                     swalWithCustomButtons.fire(
//                         "Annulé !",
//                         "Le contact n'a pas été supprimé.",
//                         "info"
//                     );
//                 }
//             });
//     });
// }
