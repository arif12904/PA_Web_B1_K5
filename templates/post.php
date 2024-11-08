<?php 
    function tampilkanDeskripsi($deskripsi){
        return strlen($deskripsi) > 100 ? substr($deskripsi, 0, 230). '...':  $deskripsi;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/post.css">
</head>
<body>
<?php
function displayPost($post) { ?>
    <div class="post-container">
        <div class="post-header">
            <div class="header-profile">
                <img src="ProfilePicture/<?= $post['foto_akun'] ?>" width="35px" height="35px" alt="profil">
                <p class="username"><?= ($post['username_akun']) ?></p>
                <p class="date"><?= $post['tanggal_upload'] ?></p>
            </div>
            <a onclick="openModal(<?= $post['id_makanan'] ?>)">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                    <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240ZM330-120 120-330v-300l210-210h300l210 210v300L630-120H330Zm34-80h232l164-164v-232L596-760H364L200-596v232l164 164Zm116-280Z"/>
                </svg>
            </a>
        </div>
        <img src="MakananUploads/<?= $post['foto_makanan'] ?>" alt="makanan">
        <h1><?= ($post['judul_makanan']) ?></h1>
        <p><?= tampilkanDeskripsi($post['deskripsi_makanan']) ?></p>
        
        <div class="post-footer">
            <div class="rate">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                    <path d="m305-704 112-145q12-16 28.5-23.5T480-880q18 0 34.5 7.5T543-849l112 145 170 57q26 8 41 29.5t15 47.5q0 12-3.5 24T866-523L756-367l4 164q1 35-23 59t-56 24q-2 0-22-3l-179-50-179 50q-5 2-11 2.5t-11 .5q-32 0-56-24t-23-59l4-165L95-523q-8-11-11.5-23T80-570q0-25 14.5-46.5T135-647l170-57Z"/>
                </svg>
                <p><?= $post['rating_makanan'] ?>/5.0</p>
            </div>
            <a href="komentar.php?id_makanan=<?= $post['id_makanan'] ?>" class="comment">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                    <path d="M80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm160-320h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80Z"/>
                </svg><?= $post['total_komentar'] ?>
            </a>
        </div>
    </div>

    <div id="modalReport-<?= $post['id_makanan'] ?>" class="modal">
        <div class="content">
            <div class="text">
                <h2 class="title">Report</h2>
                <p class="subtitle">Are you sure you want to report? Your feedback is valuable in helping us improve the community experience.</p>
            </div>
            <div class="action">
                <button class="cancel" onclick="closeModal(<?= $post['id_makanan'] ?>)">Cancel</button>
                <a href="report.php?id_makanan=<?= $post['id_makanan'] ?>">
                    <button class="report">Report</button>
                </a>
            </div>
        </div>
    </div>
<?php
}
?>
</body>

</html>