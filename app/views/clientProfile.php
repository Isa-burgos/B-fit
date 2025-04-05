<h2>👤 Profil du client</h2>

<table>
    <div class="mb-3">
        <img 
            src="<?= !empty($user['profile_picture'])? '/uploads/' . htmlspecialchars($user['profile_picture']) : '/assets/img/default-profile.jpg'?>"
            alt="Photo de profil"
            width="150"
            height="150"
            style = "border-radius: 50%; object-fit: cover;"
        >
    </div>
    <tr><th>Prénom</th><td><?= htmlspecialchars($user['firstname']) ?></td></tr>
    <tr><th>Nom</th><td><?= htmlspecialchars($user['name']) ?></td></tr>
    <tr><th>Email</th><td><?= htmlspecialchars($user['email']) ?></td></tr>
    <tr><th>Téléphone</th><td><?= htmlspecialchars($user['phone']) ?></td></tr>
    <tr><th>Adresse</th><td><?= htmlspecialchars($user['address']) ?></td></tr>
    <tr><th>Date d'inscription</th><td><?= htmlspecialchars($user['created_at']) ?></td></tr>
</table>

<a href="/admin" class="btn">← Retour</a>
<a href="/admin/user/<?= $user['id'] ?>/edit" class="btn">✏️ Modifier le profil</a>

