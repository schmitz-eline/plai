<!DOCTYPE html>
<html lang="fr-BE" itemscope itemtype="https://schema.org/WebSite">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (is_404()): ?>
        <title>Erreur 404 – PLAI</title>
    <?php endif; ?>

    <title><?= get_the_title() ?> – PLAI</title>

    <meta name="author" content="Eline Schmitz">
    <meta name="keywords" content="PLAI, Liège, élèves à besoins spécifiques, école inclusive, école, inclusion, aide, éducation, accompagnement, aménagements raisonnables">
    <meta name="description" content="Le PLAI (Pôle Liégeois d’Accompagnement vers une école Inclusive) accompagne les élèves à besoins spécifiques et les équipes éducatives dans la mise en place d’aménagements raisonnables.">

    <!-- Microdata WebSite -->
    <meta itemprop="url" content="<?= home_url(); ?>">
    <meta itemprop="name" content="PLAI">

    <!-- Microdata WebPage -->
    <meta itemprop="name" content="<?= get_the_title(); ?>">
    <meta itemprop="description" content="Le PLAI accompagne les élèves à besoins spécifiques et les équipes éducatives.">
    <link itemprop="url" href="<?= get_permalink(); ?>">

    <link rel="canonical" href="<?= get_permalink(); ?>">

    <link rel="stylesheet" href="<?= plai_asset('css') ?>">
    <script src="<?= plai_asset('js') ?>" defer></script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>