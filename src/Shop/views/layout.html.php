<?php
/**
 * @var \Framework\Renderer\Renderer $this
 * @var array $flush
 * @var string $content
 */
use Framework\DI\Service;
use Framework\Security\Roles;

?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <title>Education</title>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <link href="/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet"/>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

    <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
    <link href="/css/theme.css" rel="stylesheet">

</head>
<body role="document">

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://mindk.com"><img class="brand-logo" src="/images/img-logo-mindk-white.png"
                                                                 alt="Education"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo $this->generateRoute('home')?>">Home</a></li>
                <?php if (Service::get('security')->checkPermission([Roles::ROLE_ADMIN])) : ?>
                    <li><a href="<?php echo $this->generateRoute('create_product')?>">Add Product</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Additional
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo $this->generateRoute('manufacturers_list')?>">Manufacturers</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (is_null($user)) : ?>
                    <li><a href="<?php echo $this->generateRoute('signin')?>">Sign in</a></li>
                    <li><a href="<?php echo $this->generateRoute('login')?>">Login</a></li>
                <?php else : ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <?php echo 'Hello, '. $user->getEmail() ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo $this->generateRoute('logout')?>">Logout</a></li>
                        </ul>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<div class="container theme-showcase" role="main">
    <div class="row">
        <?php foreach($flush as $type => $msgs) :
            foreach($msgs as $msg) : ?>
                <div class="alert alert-<?= $type ?> alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <?= $msg ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <?= $content ?>
    </div>
</div>

<script type="application/javascript" src="/js/jquery.min.js"></script>
<script type="application/javascript" src="/js/bootstrap.min.js"></script>
<script type="application/javascript" src="/js/jquery.hotkeys.js"></script>
<script type="application/javascript" src="/js/bootstrap-wysiwyg.js"></script>
<script type="application/javascript">
    $(document).ready(function () {
        $('#editor').wysiwyg();
        $('#post-form').submit(function (e) {
            $('#post-content').val($('#editor').html());
        })
    });
</script>

</body>
</html>