<?php   
  use Framework\Session;
  ?>
   
    <header class="bg-rose-900 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <!-- <h1 class="text-3xl font-semibold">
          <a href="/">Fusco Art</a>
        </h1> -->
        

        <a href="/" class="flex flex-shrink-0 items-center" >
              <img class="h-10 w-auto" src='/images/logo.png' alt="Palette" >
              
              <span
                class=" flex  text-white text-4xl 
							font-bold font-['Protest Revolution'] ml-2 "
              >
                Fusco Art
              </span>
              <nav class="space-x-4">

          <?php if(Session::has('user')) : ?>  
            <div class="flex justify-between items-center gap-6">
              <div>
               Welcome <?= Session::get('user')['name']?> 
              </div>
            <form method="POST" action="/auth/logout">
            <button type="submit" class="flex ml-5 text-white  hover:underline">Logout</button>
           </form>
           
            <a
            href="/listings/create"
            class="bg-rose-300 hover:bg-rose-500 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"
            ><i class="fa fa-edit"></i> Add Artwork</a
          >
            </div>
           
          <?php else:  ?>
          <a href="/auth/login" class="inline text-white hover:underline">Login</a>
          <a href="/auth/register" class="text-white hover:underline">Register</a>
          <?php endif ?>         
        </nav>
      </div>
    </header>