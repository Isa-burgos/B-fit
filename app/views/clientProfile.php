<h2>👤 Profil du client</h2>

<div class="mb-3">
    <img 
        src="<?= !empty($user->getProfilePicture())? '/uploads/' . htmlspecialchars($user->getProfilePicture()) : '/assets/img/default-profile.jpg'?>"
        alt="Photo de profil"
        width="150"
        height="150"
        style = "border-radius: 50%; object-fit: cover;"
    >
</div>
<table>
    <tr><th>Prénom</th><td><?= htmlspecialchars($user->getFirstname()) ?></td></tr>
    <tr><th>Nom</th><td><?= htmlspecialchars($user->getName()) ?></td></tr>
    <tr><th>Email</th><td><?= htmlspecialchars($user->getEmail()) ?></td></tr>
    <tr><th>Téléphone</th><td><?= htmlspecialchars($user->getPhone()) ?></td></tr>
    <tr><th>Adresse</th><td><?= htmlspecialchars($user->getAddress()) ?></td></tr>
    <tr><th>Date d'inscription</th><td><?= htmlspecialchars($user->getCreatedAt()) ?></td></tr>
</table>

<a href="/admin" class="btn">← Retour</a>
<a href="/admin/user/<?= $user->getId() ?>/edit" class="btn">✏️ Modifier le profil</a>

