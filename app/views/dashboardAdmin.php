  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-secondary">
    <form action="" method="GET">
      <div class="input-group my-3">
          <input type="text" class="form-control input-search border-end-0" placeholder="Chercher un client">
          <button type="submit" class="btn-search border-start-0 bg-light"><img src="/assets/icons/search.svg" alt="Loupe"></button>
        </div>
    </form>
      <h3>Suivi des clients</h3>

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
                <a href="/admin/user/<?= $user->getId() ?>">👁 Voir</a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>


      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>


    </main>
  </div>
</div>