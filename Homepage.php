<!DOCTYPE html>
<html>
<title>Homepage</title>
<link rel="stylesheet" href="styles.css">

<head>

</head>

<body>
 <section class="background-containers">
   <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li class="active"><a href="#">Homepage</a></li>
                <li><a href="drugDisplay.php">Drugs</a></li>
            </ul>
        </div>
    <div class="content"><h1 id="current-time">12:00:00</h1></div>
    <div class="content">
        <h1>Welcome to Afya Health</h1>
        <h2>    .    </h2>

        <div class="button">
        <button onclick="redirectToSignUpPage()"><span></span>Sign Up</button>
        <button onclick="redirectToLoginPage()"><span></span>Log In</button>
        </div>
    </div>

 </section>

    <!----------Why---------->
 <section class="purpose">
        <h1>Why Are We Here?</h1>
        <p>We are pleased to have you all trust our platform</p>

        <div class="row">
            <div class="purpose-col">
                <h3>Mission</h3>
                <p>To provide efficient and accessible drug dispensing services, 
                    ensuring patients receive the right medications at the right time. 
                    We aim to empower healthcare providers and pharmacists with advanced 
                    technology to improve patient outcomes and enhance overall healthcare delivery.</p>
            </div>
            <div class="purpose-col">
                <h3>Vision</h3>
                <p>Our vision is to be the leading platform for drug dispensing, connecting pharmacies,
                     pharmaceutical companies, and healthcare providers seamlessly. Through innovation and collaboration,
                      we strive to create a future where every individual has easy access to safe and reliable medications,
                       contributing to a healthier and happier society.</p>
            </div>
            <div class="purpose-col">
                <h3>Motto</h3>
                <p>Delivering Health, One Prescription at a Time</p>
            </div>
 </section>

 <!----------client---------->
 <section class="client">
      <h1>We Are Here To Serve</h1>
      <p>We are pleased to have you all trust our platform</p>

       <div class="row">
          <div class="client-col">
              <img src="images/patientimage2.jpg">
              <div class="layer">
                <h3>PATIENTS</h3>
              </div>
          </div>
          <div class="client-col">
              <img src="images/doctorimage.jpg">
              <div class="layer">
                <h3>DOCTORS</h3>
              </div>
          </div>
          <div class="client-col">
              <img src="images/pharmacyimage3.jpg">
              <div class="layer">
                <h3>PHARMACIES</h3>
              </div>
          </div>
 </section>

     <!----------Testimonials---------->
     <section class="testimonial">
        <h1>What Our Clients Say</h1>
        <p>We are pleased to have you all trust our platform</p>

        <div class="row">
            <div class="testimonial-col">
             <img src="images/userfredimage.jpg">
                <div>
                <p>"As a healthcare professional, I often recommend this drug dispensing website to my patients,
                     and the feedback has been overwhelmingly positive. The website's commitment to accuracy, safety,
                      and timely delivery of medications is commendable. My patients appreciate the convenience it offers,
                       especially for those with chronic conditions who require regular refills. The website's dedication to
                        patient privacy and secure transactions instills confidence in both me and my patients. I'm delighted
                         to have such a reliable partner in ensuring my patients get the medications they need with ease.".</p>
                    <h3>Dr. Fred Bilkington</H3>
                </div>
            </div>
            <div class="testimonial-col">
             <img src="images/usersherryimage.jpg">
                <div>
                <p>"I've been using the drug dispensing services provided by this website for a while now, and I must say
                     it has been a game-changer for me. The convenience of getting my prescriptions delivered right to my doorstep
                      is unparalleled. No more waiting in long pharmacy queues or worrying about running out of essential medications.
                       The website's user-friendly interface and prompt customer support make the whole process seamless. I highly recommend
                        this platform to anyone seeking hassle-free and reliable drug dispensing services."</p>
                    <h3>Sherry Richards</H3>
                </div>
            </div>

            
 </section>

 <!----------Call to action---------->
<section class="cta">
    <h1>IN CASE OF ANY ENQUIRIES OR CONCERNS</h1>
    <a href="" class="hero-btn">CONTACT US</a>
</section>

<!----------About Us---------->
<section class="footer">
    <h4>About Us</h4>
    <p>Welcome to Afya Health, where drug dispensing is revolutionized.<br>
         We connect pharmacies, pharmaceutical companies, and healthcare providers in a seamless ecosystem.<br>
          With cutting-edge technology, pharmacists efficiently manage prescriptions, ensuring prompt and accurate medication delivery.<br>
           Patient safety is paramount; our strict quality standards guarantee the highest quality medications.<br>
            Join us in optimizing healthcare and improving patient outcomes. Experience the future of drug dispensing with Alpha Health.</p>
    <h1>FULLY FUNCTIONAL BRAINCHILD OF JOHNWILLIS ALANDE AND TOM NDEMO</h1>
</section>

    <script>
        function redirectToSignUpPage() {
            window.location.href = "CreateUser.html";
        }
        function redirectToLoginPage() {
            window.location.href = "login.html";
        }
    </script>
    <script>
        let time = document.getElementById("current-time");

        setInterval(() => {
            let d = new Date();
            time.innerHTML = d.toLocaleTimeString();
        },1000);
    
    </script>

</body>

</html>