<?php

$page_title = "Home";
include('includes/header.php');
// include('includes/navbar.php');

?>

<section id="section1">
        <section id="section2">
            <img src="img.jpg" alt="idk">
            <div class="s2-1">
            <h3><span class="multiple-text"></span></h3>
            <p>Profess-a-pal streamlines education with secure authentication, data synchronization for labs and theory, anti-cheating measures, and productivity tools, fostering academic integrity and student success.</p>
            </div>
        </section>
        <section id="section3">
            <h2>Get Started</h2>
            <div class="s3-1">
                <!-- <a href="login.php" class="nunnu">    
                    <button id="loginBtn"> login
                        <span></span>
                    </button>
                </a> -->
                <button id="loginBtn"> login
                        <span></span>
                    </button>
                
                <br>
                <a href="register.php" class="nunnu">
                    <button id="signupBtn"> signup
                        <span></span>
                    </button>
                </a>
                <!-- <button id="signupBtn"> signup
                        <span></span>
                </button> -->
            </div>
        </section>
    
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you a:</p>
            <button id="studentBtn">Student</button>
            <button id="teacherBtn">Teacher</button>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const typed = new Typed('.multiple-text',{
        strings:['Profess-a-pal'],
        typeSpeed: 100,
        backSpeed: 100,
        backDelay: 1000,
        loop: true,
    });
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var loginBtn = document.getElementById("loginBtn");
    var signupBtn = document.getElementById("signupBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    loginBtn.onclick = function() {
    modal.style.display = "block";
    }

    // signupBtn.onclick = function() {
    // modal.style.display = "block";
    // }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }

    // Handle button clicks in the modal
    var studentBtn = document.getElementById("studentBtn");
    var teacherBtn = document.getElementById("teacherBtn");

    studentBtn.onclick = function() {
    // alert("You clicked 'Student'");
    window.location.href = "studentlogin.html";
    modal.style.display = "none";
    }

    teacherBtn.onclick = function() {
    // alert("You clicked 'Teacher'");
    window.location.href = "login.php";
    modal.style.display = "none";
    }

});

</script>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>



<?php include('includes/footer.php'); ?>