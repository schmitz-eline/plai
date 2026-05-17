<!doctype html>
<html lang="fr-BE" itemscope itemtype="https://schema.org/WebSite">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Eline Schmitz">
    <meta name="keywords"
          content="PLAI, Liège, élèves à besoins spécifiques, école inclusive, école, inclusion, aide, éducation, accompagnement, aménagements raisonnables"
    <meta name="description"
          content="Le PLAI (Pôle Liégeois d’Accompagnement vers une école Inclusive) accompagne les élèves à besoins spécifiques et les équipes éducatives dans la mise en place d’aménagements raisonnables.">

    <!-- Microdata WebSite -->
    <meta itemprop="url" content="<?= home_url(); ?>">
    <meta itemprop="name" content="PLAI">

    <!-- Microdata WebPage -->
    <meta itemprop="name" content="<?= get_the_title(); ?>">
    <meta itemprop="description"
          content="Le PLAI (Pôle Liégeois d’Accompagnement vers une école Inclusive) accompagne les élèves à besoins spécifiques et les équipes éducatives dans la mise en place d’aménagements raisonnables.">
    <link itemprop="url" href="<?= get_permalink(); ?>">

    <link rel="canonical" href="<?= get_permalink(); ?>">
    <link rel="stylesheet" type="text/css" href="<?= plai_asset('css') ?>">
    <script src="<?= plai_asset('js') ?>" defer></script>
    <title><?= get_the_title() ?> - PLAI</title>
</head>

<body>
<header class="header" itemscope itemtype="https://schema.org/WPHeader"></header>

<main class="main" itemscope itemtype="https://schema.org/WebPage">
    <h1>Ceci est ma page d’accueil</h1>
</main>

<footer class="footer" itemscope itemtype="https://schema.org/WPFooter"></footer>
</body>
</html>