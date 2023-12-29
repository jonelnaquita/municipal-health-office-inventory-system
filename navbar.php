<style>
    a.nav-item,
    .dd {
        position: relative;
        display: block;
        padding: .95rem 2.25rem;
        margin-bottom: -1px;
        border: 2.5px solid #333;
        background-color: #17e723;
        background: linear-gradient(45deg, #5b93d5, #5b93d5);
        color: #ffdfdf;
        font-weight: 600;
    }

    a.nav-item:hover,
    .nav-item.active,
    .dropdown-toggle:hover,
    .dropdown-toggle.active {
        background-color: ##000000ad;
        color: black;
    }

    .dropdown-toggle {
        color: #ffdfdf;
    }
</style>

<nav id="sidebar" class='mx-lt-5 bg-white'>

    <div class="sidebar-list">

        <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Dashboard</a>
        <a href="index.php?page=list" class="nav-item nav-inventory"><span class='icon-field'><i class="fa fa-list"></i></span> Inventory</a>

        <?php if ($_SESSION['login_type'] == 1): ?>
            <div class=" dd">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Medicine</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="index.php?page=categories"><i class="fa fa-list"></i> Category</a>
                    <a class="dropdown-item" href="index.php?page=types"><i class="fa fa-th-list"></i> Types</a>
                </div>
            </div>
        <?php endif; ?>

        <a href="index.php?page=expired_product" class="nav-item nav-expired_product"><span class='icon-field'><i class="fa fa-list"></i></span> Expired List</a>
		<a href="index.php?page=stock_out" class="nav-item nav-stock-out"><span class='icon-field'><i class="fa fa-list"></i></span> Stock Out</a>
        <a href="index.php?page=supplier" class="nav-item nav-supplier"><span class='icon-field'><i class="fa fa-truck-loading"></i></span> Supplier List</a>

        <?php if ($_SESSION['login_type'] == 1): ?>
            <a href="index.php?page=customer" class="nav-item nav-customer"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Patient List</a>
            <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
        <?php endif; ?>
    </div>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</nav>
<script>
    $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
<?php if ($_SESSION['login_type'] != 3) :
elseif ($_SESSION['login_type'] != 1) : ?>
    <style>
        .nav-item {
            display: none!important;
        }

        .nav-sales,
        .nav-home,
        .nav-inventory {
            display: block!important;
        }
    </style>
<?php endif ?>
