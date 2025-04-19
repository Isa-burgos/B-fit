<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-secondary">

    <h2 class="mb-3">Créer un programme d'entraînement</h2>

    <form method="POST" action="/admin/training/create" id="program-form">
        <input class="form-control mb-3" type="text" name="title" placeholder="Titre du programme" required>
        <textarea class="form-control mb-3" name="description" placeholder="Description du programme" required></textarea>

        <label for="client" class="form-label">Sélection du client</label>
        <select class="form-select mb-3" name="user_id" id="client">
            <option value=""></option>
        </select>
        
        <h3>Sélection d'exercices</h3>
        <ul id="exercise-list"></ul>

        <h4>Exercices ajoutés :</h4>
        <ul id="selected-exercises"></ul>

        <!-- Liste cachée à soumettre -->
        <div id="hidden-inputs"></div>

        <button class="btn btn-primary" type="submit">Créer le programme</button>
    </form>

</main>