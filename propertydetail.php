<?php
session_start();
include('./config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('./include/head.php');
    if($_POST ['submit'] == 'submit') {
        $destinataire   = $_POST ['agent'];
        $expediteur     = $_POST['email'];
        $subject        = 'Demande d\'info de bien immo';
        $header         = 'MINE-Version: 1.0' . "\n";
        $header        .= 'Reply-To: '.$expediteur ."\n";
        $header        .= 'From: "Nom de l\'expediteur"<'.$expediteur.'>' ."\n";
        $header        .= 'Delivred-to:'.$destinataire ."\n";

        //si je veux envoyer un emil en format en html : 
        $header        .= 'Content-Type: text/html; charset=UTF-8';
        $message        = '<p>name:'.$_POST['firstname'].'</p>
                           <p>email:'.$_POST['email'].'</p>
                           <p>phone:'.$_POST['phone'].'</p>
                           <p>message:'.$_POST['message'].'</p>';

        if(mail($destinataire, $subject, $message, $header)) {
            echo 'Message bien envoyé';
        }

    }

    ?>
</head>

<body>
    <div id="page-wrapper">
        <div class="row">
            <?php include('./include/header.php') ?>
            <div class="banner-full-row page-banner" style="background-image: url('images/breadcromb.jpg');">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-uppercase mt-0 mb-0">Property Detail</h2>
                    </div>
                    <div class="col-md-6">
                        <nav class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="index.php"></a></li>
                                <li class="breadcrumb-item active">Property Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="full-row">
                <div class="container">
                    <div class="row">
                        <?php
                        $id    = $_GET['pid'];
                        $query = mysqli_query($con, "SELECT property.*, user.* FROM property, user WHERE property.uid = user.uid AND pid ='$id'");
                        while ($row = mysqli_fetch_array($query)) {

                        ?>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="single-property" style="width: 1200px; height : 700px; margin : 30px auto 50px;">
                                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;">
                                                <img src="./admin/property/<?= $row['18']; ?>" alt="" width="1920" height="1080" class="ls-bg">
                                            </div>
                                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;">
                                                <img src="./admin/property/<?= $row['19']; ?>" alt="" width="1920" height="1080" class="ls-bg">
                                            </div>
                                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;">
                                                <img src="./admin/property/<?= $row['20']; ?>" alt="" width="1920" height="1080" class="ls-bg">
                                            </div>
                                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;">
                                                <img src="./admin/property/<?= $row['21']; ?>" alt="" width="1920" height="1080" class="ls-bg">
                                            </div>
                                            <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;">
                                                <img src="./admin/property/<?= $row['22']; ?>" alt="" width="1920" height="1080" class="ls-bg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <diw class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="bg-primary d-table px-3 py-2 rounded text-capitalize text-white">
                                            for: <?php echo $row['5']; ?>
                                        </div>
                                        <h5 class="mt-2 text-secondary text-capitalize">
                                            <?php echo $row['1']; ?>
                                        </h5>
                                        <span class="mb-sm-20 d-block text-capitalize">
                                            <i class="fas fa-map-marker-alt text-primary font-12"></i> &nbsp;
                                            <?php echo $row['14']; ?>
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-primary text-left h5 my-2 text-md-right">

                                            <?php
                                            //Affichons le prix au format international en EN/US
                                            $f = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
                                            echo $f->formatCurrency($row['13'], "USD");
                                            ?>

                                        </div>
                                        <div class="text-left text-md-right">Price</div>
                                    </div>
                                </diw>
                                <div class="property-details">
                                    <div class="bg-gray property-quantity px-4 pt-4-w-100">
                                        <ul>
                                            <li><span class="text-secondary"><?= $row['12']; ?></span>sqft²</li>
                                            <li><span class="text-secondary"><?= $row['7']; ?></span>Bedroom</li>
                                            <li><span class="text-secondary"><?= $row['6']; ?></span>Bathroom</li>
                                            <li><span class="text-secondary"><?= $row['8']; ?></span>Balcony</li>
                                            <li><span class="text-secondary"><?= $row['10']; ?></span>Hall</li>
                                            <li><span class="text-secondary"><?= $row['9']; ?></span>Kitchen</li>
                                        </ul>
                                    </div>
                                    <h4 class="text-secondary my-4">Description</h4>
                                    <p><?= $row['2']; ?></p>
                                    <h5 class="mt-5 mb-4 text-secondary">Property Sumary</h5>
                                    <div class="table-striped font-14 mb-2">
                                        <table class="w-100">
                                            <tbody>
                                                <tr>
                                                    <td>BHK</td>
                                                    <td class="text-capitalize"><?= $row['4']; ?></td>
                                                    <td>Property Type</td>
                                                    <td class="text-capitalize"><?= $row['3']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>FLOOR</td>
                                                    <td class="text-capitalize"><?= $row['11']; ?></td>
                                                    <td>Total Floor</td>
                                                    <td class="text-capitalize"><?= $row['28']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>CITY</td>
                                                    <td class="text-capitalize"><?= $row['15']; ?></td>
                                                    <td>State</td>
                                                    <td class="text-capitalize"><?= $row['16']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h5 class="mt-5 mb-4 text-secondary">Featured</h5>
                                    <div class="row">
                                        <?= $row['17']; ?>
                                    </div>
                                    <h5 class="mt-5 mb-4 text-secondary">Floor Plans</h5>
                                    <div class="accordion" id="accordionExample">
                                        <button class="bg-gray hover-bg-primary hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Floor Plans </button>
                                        <div id="collapseOne" class="collapse show p-4" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <img src="admin/property/<?php echo $row['25']; ?>" alt="Not Available">
                                        </div>
                                        <button class="bg-gray hover-bg-primary hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Basement Floor</button>
                                        <div id="collapseTwo" class="collapse p-4" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <img src="admin/property/<?php echo $row['26']; ?>" alt="Not Available">
                                        </div>
                                        <button class="bg-gray hover-bg-primary hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Ground Floor</button>

                                        <div id="collapseThree" class="collapse p-4" aria-labelledby="headingThree" data-parent="#accordionExample">
                                            <img src="admin/property/<?php echo $row['27']; ?>" alt="Not Available">
                                        </div>
                                    </div>
                                    <h5 class="position-relative double-down-line-left text-secondary mt-5 mb-4">Contact Agent</h5>
                                    <div class="agent-contact pt-60">
                                        <div class="row">
                                            <div class="col-sm-4 col-lg-3">
                                                <img src="admin/user/<?php echo $row['uimage'] ?>" alt="avatar" width="170" height="200">
                                            </div>
                                            <div class="col-sm-8 col-lg-9">
                                                <div class="agent-data text-ordinary mt-sm-20">
                                                    <h6 class="text-primary text-capitalize"><?php echo $row['uname']; ?></h6>
                                                    <ul class="mb-3">
                                                        <li><?php echo $row['uphone']; ?></li>
                                                        <li><?php echo $row['uemail']; ?></li>
                                                    </ul>
                                                    <div class="mt-3 text-secondary hover-text-primary">
                                                        <ul>
                                                            <li class="float-left mr-3"><a href=""><i class="fab fa-facebook-f"></i></a></li>
                                                            <li class="float-left mr-3"><a href=""><i class="fab fa-twitter"></i></a></li>
                                                            <li class="float-left mr-3"><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                                                            <li class="float-left mr-3"><a href=""><i class="fab fa-linkedin-in"></i></a></li>
                                                            <li class="float-left mr-3"><a href=""><i class="fas fa-rss"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <form action="" method="post" class="bg-gray-form mt-5">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control bg-gray" id="name" name="firstname" placeholder="your name">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control bg-gray" id="email" name="email" placeholder="your email">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control bg-gray" id="phone" name="phone" placeholder="your phone">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                    <input type="hidden"  name="agent" value="<?= $row ['uemail']?>">
                                                                        <button type="submit" id="send" value="submit" class="btn btn-primary" name="submit">Send Your Message</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <textarea name="message" id="message" cols="30" rows="5" class="form-control bg-gray mt-sm-20"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-lg-4">
                            <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-md-50">Send Message</h4>
                            <form method="post" action="#">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Enter Message"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary w-100">Search Property</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <h4 class="double-down-line-left text-secondary position-relative pb-4 my-4">Instalment Calculator</h4>
                            <form class="d-inline-block w-100" action="calc.php" method="post">
                                <label class="sr-only">Property Amount</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                    </div>
                                    <input type="text" class="form-control" name="amount" placeholder="Property Price">
                                </div>
                                <label class="sr-only">Month</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="month" placeholder="Duration Year">
                                </div>
                                <label class="sr-only">Interest Rate</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                    </div>
                                    <input type="text" class="form-control" name="interest" placeholder="Interest Rate">
                                </div>
                                <button type="submit" value="submit" name="calc" class="btn btn-primary mt-4">Calclute Instalment</button>
                            </form>
                            <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-5">Featured Property</h4>

                            <div class="sidebar-widget mt-5">
                                <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4">Recent Property Add</h4>
                                <ul class="property_list_widget">

                                    <?php
                                    $query = mysqli_query($con, "SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <li> <img src="admin/property/<?php echo $row['18']; ?>" alt="pimage">
                                            <h6 class="text-secondary hover-text-primary text-capitalize">
                                                <a href="propertydetail.php?pid=<?php echo $row['0']; ?>"><?php echo $row['1']; ?></a>
                                            </h6>
                                            <span class="font-14"><i class="fas fa-map-marker-alt icon-primary icon-small">
                                                </i> <?php echo $row['14']; ?>
                                            </span>

                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


    <?php include('./include/footer.php') ?>

    <script src="js/jquery.min.js"></script>
    <!--jQuery Layer Slider -->
    <script src="js/greensock.js"></script>
    <script src="js/layerslider.transitions.js"></script>
    <script src="js/layerslider.kreaturamedia.jquery.js"></script>
    <!--jQuery Layer Slider -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/tmpl.js"></script>
    <script src="js/jquery.dependClass-0.1.js"></script>
    <script src="js/draggable-0.1.js"></script>
    <script src="js/jquery.slider.js"></script>
    <script src="js/wow.js"></script>
    <script src="js/YouTubePopUp.jquery.js"></script>
    <script src="js/validate.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>