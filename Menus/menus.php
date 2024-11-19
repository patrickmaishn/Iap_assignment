<?php
class menus{
    public function main_menu(){
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
            
        </svg>

        <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
            <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
                    id="bd-theme"
                    type="button"
                    aria-expanded="false"
                    data-bs-toggle="dropdown"
                    aria-label="Toggle theme (auto)">
                <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
                <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                        Light
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                        Dark
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                        <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
                        Auto
                    </button>
                </li>
            </ul>
        </div>

        <main>
            <div class="container py-4">
                <header class="pb-3 mb-4 border-bottom">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Ninth navbar example">
                        <div class="container-xl">
                            <a class="navbar-brand" href="./">CHELS</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarsExample07XL">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="./">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Contact Us</a>
                                    </li>
                                    
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <!-- If user is logged in, display their username and a logout link -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="logout.php">Logout</a> <!-- Add logout page -->
                                        </li>
                                    <?php else: ?>
                                        <!-- If user is not logged in, display Sign Up link -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="/class/Iap_assignment/Sign Up/signup.php">Sign Up</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <form role="search">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                </form>
                            </div>
                        </div>
                    </nav>
                </header>
        <?php
    }

    public function main_right_menu(){
        ?>
        <div class="topnav-right">
            <?php if (isset($_SESSION['username'])): ?>
                <!-- If user is logged in, display username and logout option -->
                <a href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <a href="class/Iap_assignment/Sign%20Up/login.php">Logout</a>
            <?php else: ?>
                <!-- If user is not logged in, display Sign Up and Sign In links -->
                <a href="/class/Iap_assignment/Sign Up/signup.php">Sign Up</a>
                <a href="/class/Iap_assignment/Sign In/signin.php">Sign In</a>
            <?php endif; ?>
        </div>
        <?php
    }
}
