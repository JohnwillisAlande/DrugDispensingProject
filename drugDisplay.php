<!DOCTYPE html>
<html>
<title>Drugs</title>
<link rel="stylesheet" href="styles.css">

<head>

</head>

<script>
  function scrollToSection(sectionId) {
    var section = document.getElementById(sectionId);
    section.scrollIntoView({ behavior: 'smooth' });
  }
</script>

<body>
 <section class="background-containers">
   <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="Homepage.php">Homepage</a></li>
                <li class="dropdown active"> 
                <a href="#" onclick="scrollToSection('types')">Drugs</a>
          <ul class="dropdown-content">
            <li><a href="#" onclick="scrollToSection('types')">Brief</a></li>
            <li><a href="#" onclick="scrollToSection('antibiotics')">Antibiotics</a></li>
            <li><a href="#" onclick="scrollToSection('painkillers')">Painkillers</a></li>
            <li><a href="#" onclick="scrollToSection('antidepressants')">Antidepressants</a></li>
            <li><a href="#" onclick="scrollToSection('creams')">Creams</a></li>
          </ul>
        </li>
            </ul>
        </div>
    <div class="content">
        <h1>Welcome to Afya Health</h1>
        <h2>Drug Inventory</h2>
    </div>

 </section>

    <!----------Types---------->
 <section id="types" class="purpose">
        <h1>What types of drugs do we stock?</h1>
        <p>Have a look at some types of the drugs that can be found on our web application</p>

        <div class="row">
            <div class="drug-col">
                <h3>Antibiotics</h3>
                <p>Antibiotics are medications used to treat bacterial infections
                     by inhibiting the growth or killing bacteria.</p>
            </div>
            <div class="drug-col">
                <h3>Painkillers</h3>
                <p>Painkillers, also known as analgesics, help reduce or alleviate pain,
                     often by blocking pain signals in the nervous system.</p>
            </div>
            <div class="drug-col">
                <h3>Antidepressants</h3>
                <p>Antidepressants are drugs prescribed to manage and alleviate symptoms
                     of depression and other mood disorders by affecting neurotransmitter
                      levels in the brain.</p>
            </div>
            <div class="drug-col">
                <h3>Relief Creams</h3>
                <p>Relief creams are topical ointments or gels applied to the skin to provide
                     localized relief from pain, itching, inflammation, or skin conditions.</p>
            </div>
 </section>

 <!----------Antibiotics---------->
 <section id="antibiotics" class="client">
      <h1>ANTIBIOTICS</h1>
      <p>Have a look at some of the antibiotics that can be found on our web application</p>

       <div class="row">
          <div class="client-col">
              <img src="images/calpol.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Calpol" title="Calpol" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/penicillin2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Penicillin" title="Penicillin" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/ciprosafe2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Ciprosafe" title="Ciprosafe" class="hero-btn">View Details</a>
              </div>
          </div>
 </section>

     <!----------Painkillers---------->
     <section id="painkillers" class="client">
      <h1>PAINKILLERS</h1>
      <p>Have a look at some of the painkillers that can be found on our web application</p>

       <div class="row">
          <div class="client-col">
              <img src="images/panadol2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Panadol" title="Panadol" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/sonamoja2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Sonadol" title="SonaMoja" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/hedex2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Hedex" title="Hedex" class="hero-btn">View Details</a>
              </div>
          </div>
 </section>

 <!----------Antidepressants---------->
 <section id="antidepressants" class="client">
      <h1>ANTIDEPRESSANTS</h1>
      <p>Have a look at some of the antidepressants that can be found on our web application</p>

       <div class="row">
          <div class="client-col">
              <img src="images/prozac2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Prozac" title="Prozac" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/amitriptyline2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Amitriptyline" title="Amitriptyline" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/citalopram2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Citalopram" title="Citalopram" class="hero-btn">View Details</a>
              </div>
          </div>
 </section>

<!----------About Us---------->
<section id="creams" class="client">
      <h1>RELIEF CREAMS</h1>
      <p>Have a look at some of the relief creams that can be found on our web application</p>

       <div class="row">
          <div class="client-col">
              <img src="images/deepheat2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=DeepHeat" title="DeepHeat" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/diclac2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Diclac" title="Diclac" class="hero-btn">View Details</a>
              </div>
          </div>
          <div class="client-col">
              <img src="images/deflam2.jpg">
              <div class="layer">
                <a href="drugDetails.php?tradename=Deflam" title="Deflam" class="hero-btn">View Details</a>
              </div>
          </div>
 </section>

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

</body>

</html>