<template id="homepage">
 <div class="homepage">
     
    <navigation></navigation>
    
   <section class="main-section mt-5">
       <div class="container">
           <div class="row">
               <div class="col-md-6 bg">
                  <h2 class="h2-section">Faça sua conta</h2>
                   <register-form></register-form>
               </div>
               <div class="col-md-6">
                   
               </div>
           </div>
       </div>
    </section>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
   <br>
    </div>
</template>

<script>
    import RegisterForm from './RegisterForm.vue';
    import Navigation from './Navigation';
    
    export default {
        components: {
            'navigation': Navigation,
            'register-form': RegisterForm
       }
    }
</script>
