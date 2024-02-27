 
        <x-guest-layout>   
    <!-- Main content -->
   <main   class="m-0 p-0 pt-3">
 <section class="slice pb-7" >
   <div class=" hero-container-background"></div>
   <div class=" hero-container-background-bottom"></div>

      <div class="container ">
        <div class="row row-grid align-items-center mt-md-5 pt-md-5" >
          <div class="col-12 col-md-5 col-lg-6 order-md-2 text-center">
            <!-- Image -->
            <figure class="w-100   p-3">
              <img
                alt="Image placeholder"
                src="{{ asset('images/background/goals.svg')}}"
                class="img-fluid hero-img mw-md-110"
              />
            </figure>
          </div>
          <div class="col-12 col-md-7 col-lg-6 order-md-1 pr-md-5  py-4 pl-3">
            <!-- Heading -->
            <h1 class="display-4   text-center text-md-left mb-3 px-0 mx-0 font-weight-bold">              
              Hungry for More? <br />
            </h1>
            <h2 class="display-4 font-weight-bold">
              Discover amazing wholesale deals!
             </h2>
            <!-- Text -->
            <p class="lead text-center text-md-left text-muted ">
              Ditch the supermarket struggles. We're serving up epic deals on everything.
              Bulk up your inventory and watch your profits sizzle
             </p>
            <!-- Buttons -->
            <div class="text-center text-md-left mt-3 ">
              <a
                href="tel:0645466435"
                class="btn  btn-outline-info fond-weight-bold w-100 rounded"
                 > Contact us Now &nbsp; <i class="fa fa-phone" aria-hidden="true"></i></a
              >
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <section class="slice slice-lg pt-lg-6 pb-0 pb-lg-6 bg-section-secondary d-none" id="services">
      <div class="container">
        <!-- Title -->
        <!-- Section title -->
        <div class="row mb-5 justify-content-center text-center">
          <div class="col-lg-8">
            <h2 class="mt-4 font-weight-bold">
              Some of our interesting Services
            </h2>
            <div class="mt-2">
              <p class="lead lh-180">
                Whether you already have a running business or you want to start
                from scracth, We are here to help you.
              </p>
            </div>
          </div>
        </div>
        <!-- Card -->
        <div class="row mt-5">
          <div class="col-md-4">
            <div class="card hover-translate-y-n10 hover-shadow-lg">
              <div class="card-body pb-2 ">
                <h3 class="text-center text-grey">E-commerce Store</h3>
                <div class="pt-4 pb-5">
                  <img
                  loading="lazy"
                    src="assets/img/svg/illustrations/market.svg"
                    class="img-fluid img-center img-service"
                    style="height: 150px"
                    alt="Illustration"
                  />
                </div>
                <h5 class="h5 lh-130 mb-2 w-100">
                  Do you want an online store?
                </h5>
                <p class="mb-2 font-weight-300 ">
                 We have different packages for you, that can suit your business needs.
                 Whether you think to sell one product or thausands of products,
                 these packages are affordable and good for you. No technical skills requered,
                  our team will help you to set up everything for free plus you will get 24/7 free support.
                  What are you waiting for? Let us help you
                </p>      
<div class="text-center border-top"><a href="#ecommerce" class="btn btn-sm rounded btn-outline-dark-green">create store now</a>
</div>
              </div>
            </div>
          </div>
          <div class="col-md-4 ">
            <div class="card hover-translate-y-n10 hover-shadow-lg">
              <div class="card-body pb-2">
                <h3 class="text-center text-grey">Custom Web App</h3>
                <div class="pt-4 pb-5">
                  <img
                  loading="lazy"
                    src="assets/img/svg/illustrations/illustration-4.svg"
                    class="img-fluid img-center img-service"
                    style="height: 150px"
                    alt="Illustration"
                  />
                </div>
                <h5 class="h5 lh-130 mb-2">
                  Do you want a custom web app?
                </h5>
                <p class="mb-2 font-weight-300">
                  Do you have an idea or project in mind? Let us help you,
                  it doesn't matter how big or small your idea/project it is,
                  you need good team to take care of it and make it be successful.
                  Whether it's idea, project or you need maintanance for your project, We will be happy to help you.
                  We give full six month of free support for projects we built. Is that what you want?
                </p><div class="text-center border-top ">  
                  <a href="contact.html" class="btn btn-sm rounded btn-outline-deep-purple">contact us now</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card hover-translate-y-n10 hover-shadow-lg">
              <div class="card-body pb-2">
                <h3 class="text-center text-grey">Business E-mail</h3>
                <div class="pt-4 pb-5">
                  <img
                  loading="lazy"
                    src="assets/img/svg/illustrations/mail-open.svg"
                    class="img-fluid img-service img-center"
                    style="height: 150px;"
                    alt="Illustration"
                  />
                </div>
                <h5 class="h5 lh-130 mb-3 ">Do you want Proffesional email?</h5>
                <p class="mb-0 font-weight-300">
                  No one will trust your business if you use email address like
                  <span class="small font-italic blue-grey-text">[you@gmail.com, you@outlook.com or you@yahoo.com]</span> 
                  If you are not seriouse, your customers wont be serious too. 
                  Your business need something proffesional.
                  let us help you to bring trust to your customers.
                  We will help you with a proffesional business email. Be proffesional.

                </p><div class="text-center border-top">
                  <a href="contact.html" class="btn btn-sm rounded btn-outline-blue-grey">contact us now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

        <section class="slice slice-lg pt-5 d-none">
      <div class="container text-center text-lg-left">
        <!-- Title -->
        <div class="d-flex justify-content-center w-100">
          <div class="h3">Who we partnered with</div>
        </div>
        <!-- Team -->
        <div class="row py-5 ">
          @for ($i = 0; $i < 4; $i++)
          <div class="col-lg-3">
            <div class="card text-center hover-translate-y-n10 hover-shadow-lg">
              <div class="py-2 px-2">
                <img 
                loading="lazy"
                  src="https://www.tigerbrands.com/-/media/Project/TigerBrands/DotCom/News/ArticleImg-WhiteTiger.jpg?"
                  class="w-100 "
                  alt="Tiger Brands"/>
                <div class="">
                  <p class="h5">
                    Tiger Brands <br /><small
                      class="font-italic text-black-50"
                      >South African packaged goods company</small>
                  </p>
                </div>
              </div>
            </div>
          </div>
          @endfor            
        </div>
      </div>
    </section>
   </main>
  </x-guest-layout>  
