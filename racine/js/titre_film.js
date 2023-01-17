function functionTitre() {
    let strTitre = document.getElementById("titre").value;

    // Vérifie si la chaîne commence par une lettre majuscule
    strTitre = strTitre.charAt(0).toUpperCase() + strTitre.slice(1);

    // Enlève les caractères spéciaux de la chaîne
    strTitre = strTitre.replace(/[^a-zA-Z0-9 :-ÀÁÆÇÈÉÊÙÚÛàáæçèéêëùúû]/g, "");

    // Vérifie si la chaîne contient au moins 3 lettres
    if (!/[a-zA-Z]{3,}/.test(strTitre)) {
        alert("Le titre doit contenir au moins 3 lettres");
    }
    else {
        // Met à jour l'input avec la chaîne formatée
        document.getElementById("titre").value = strTitre;
        document.getElementById("titre_du_film").innerHTML = strTitre;
        document.getElementById("titre_2").innerHTML = strTitre;
    }
}

document.getElementById("randomTitleButton").addEventListener("click", function() {

    // Génère un nombre au hasard entre 0 et la longueur du tableau filmTitles
    const filmTitles = ["Eternal Sunshine", "Vol au-dessus d'un nid de coucou", "Requiem for a Dream", "De battre mon cœur s'est arrêté", "Le Tombeau des lucioles", "Les Contes de la lune vague après la pluie", "Le Cercle des poètes disparus", "Une vie de bestiole", "16 rues", "Encore 17 ans", "24 heures avant nuit", "13 ans, bientôt 30", "Gone in 60 Seconds", "Edge, The"];
    const randomIndex = Math.floor(Math.random() * filmTitles.length);

    // Récupère le titre de film au hasard à partir de l'index aléatoire
    const randomTitle = filmTitles[randomIndex];

    // Met à jour l'input de titre avec le titre de film au hasard
    document.getElementById("titre").value = randomTitle;
    document.getElementById("titre_du_film").innerHTML = randomTitle;
    document.getElementById("titre_2").innerHTML = randomTitle;
});