<h2>✏️ Modifier le profil utilisateur</h2>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif ?>

<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif ?>

<form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="current_picture" value="<?= htmlspecialchars($user->getProfilePicture()) ?>">

  <div>
    <label>Prénom</label>
    <input type="text" name="firstname" value="<?= htmlspecialchars($user->getFirstname()) ?>">
  </div>

  <div>
    <label>Nom</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user->getName()) ?>">
  </div>

  <div>
    <label>Téléphone</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($user->getPhone()) ?>">
  </div>

  <div>
    <label>Adresse</label>
    <input type="text" name="address" value="<?= htmlspecialchars($user->getAddress()) ?>">
  </div>

  <div>
    <label>E-mail</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>">
  </div>

  <div>
    <label>Photo de profil</label><br>
    <?php if (!empty($user->getProfilePicture())): ?>
      <img src="/uploads/<?= htmlspecialchars($user->getProfilePicture()) ?>" width="100" style="border-radius: 50%;"><br>
    <?php endif ?>
    <input type="file" name="profile_picture" accept="image/*">
  </div>

  <button type="submit">Enregistrer</button>
</form>

<p><a href="/admin/user/<?= $user->getId() ?>">← Retour à la fiche</a></p>
