<?php if ($success): ?>
    <p style="color: green"><?= $success ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color: red"><?= $error ?></p>
<?php endif; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-secondary">
    <h2>Créer un nouvel utilisateur</h2>

    <form action="/admin" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="form-floating mb-3 col-md-6">
                <input type="text" class="form-control" id="firstnameInput" placeholder="Prénom" required>
                <label for="firstnameInput">Prénom</label>
            </div>
            <div class="form-floating mb-3 col-md-6">
                <input type="text" class="form-control" id="nameInput" placeholder="Nom" required>
                <label for="nameInput">Nom</label>
            </div>
            <div class="form-floating mb-3 col-md-6">
                <input type="text" class="form-control" id="phoneInput" placeholder="Téléphone" required>
                <label for="phoneInput">Téléphone</label>
            </div>
            <div class="form-floating mb-3 col-md-6">
                <input type="text" class="form-control" id="addressInput" placeholder="Adresse" required>
                <label for="addressInput">Adresse</label>
            </div>
            <div class="form-floating mb-3 col-md-6">
                <input type="email" class="form-control" id="emailInput" placeholder="E-mail" required>
                <label for="emailInput">E-mail</label>
            </div>
            <div class="form-floating mb-3 col-md-6">
                <input type="password" class="form-control" id="passwordInput" placeholder="Mot de passe" required>
                <label for="passwordInput">Mot de passe</label>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Photo de profil</label>
                <input class="form-control" type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary col-md-6 mx-auto">Créer le compte</button>
        </div>
    </form>

    <hr>
    <h2>👥 Utilisateurs enregistrés</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <img 
                        src="<?= !empty($user->getProfilePicture()) ? '/uploads/' . htmlspecialchars($user->getProfilePicture()) : '/assets/img/default-profile.jpg' ?>"
                        alt="Photo de profil"
                        width="50"
                        height="50"
                        style = "border-radius: 50%; object-fit: cover;"
                    >
                </td>
                <td><?= htmlspecialchars($user->getFirstname()) ?></td>
                <td><?= htmlspecialchars($user->getName()) ?></td>
                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                <td>
                    <a href="/admin/user/<?= $user->getId() ?>">👁 Voir</a> |
                    <a href="/admin?delete=<?= $user->getId() ?>" onclick="return confirm('Supprimer ce client ?')">🗑 Supprimer</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</main>