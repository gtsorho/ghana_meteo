<template>
    <div class="card text-center  align-self-end">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        <div class="card-footer text-muted">
            2 days ago
        </div>
    </div>
</template>
<script>
export default {
    
}
</script>
<style scoped>
    .card{
    background-color: #e7e7e7db;
    backdrop-filter: blur(7px);
    border:none;
    border-radius: none;
   
        width: 100%;
        height: 57.5%;
    }
    /* If the screen size is 1000px or more, set the font-size of <div> to 80px */
@media only screen and (max-width: 768px) {
    .card{
        height: 50.5% !important;
    }
}
</style>