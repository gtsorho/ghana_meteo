<template >

    <div class="row p-3 h-100 row-cols-1 row-cols-sm-1 row-cols-md-2">
        <div class="col  left">
                <Adminlefttop :updatedata="datatoupdate"/>
                <br>
                <Adminleftbottom/>
        </div>
        <div class="col right">
            <Adminright @datatoupdate="datatoupdate=$event"/>            
        </div>
        
    </div>
    
    
    
    
</template>
<script>
import Adminlefttop from '../components/adminlefttop.vue'
import Adminleftbottom from '../components/adminleftbottom.vue'
import  Adminright from '../components/adminright.vue'
import axios from 'axios'
export default {
    components:{
        Adminright,
        Adminleftbottom,
        Adminlefttop
    },
    beforeCreate: function() {
        document.getElementById("app").classList.add("appheight");  
    },
    data() {
        return {
            datatoupdate:[]
        }
    },
}
</script>
<style scoped>
.left {
    /* padding: 1%; */
    height: 100%;

}
.right{
    height: 100%;
}
    /* If the screen size is 1000px or more, set the font-size of <div> to 80px */
@media only screen and (max-width: 768px) {
    .right{
        margin-top : 10% !important;
        margin-bottom : 10% !important;

}
}
</style>
<style>
    .appheight{
        height: 100%;
    }
    :root {
    /* --popper-theme-background-color: #333333;
    --popper-theme-background-color-hover: #333333; */
    --popper-theme-text-color: #000000;
    /* --popper-theme-border-width: 0px;
    --popper-theme-border-style: solid;
    --popper-theme-border-radius: 6px; */
    /* --popper-theme-padding: 5px; */
    /* --popper-theme-box-shadow: 0 6px 30px -6px rgba(0, 0, 0, 0.25); */
    }
        .mx-input {
    display: inline-block;
    box-sizing: border-box;
    width: 100%;
    height: unset !important;
    padding: 0px 30px !important;
    padding-left: 10px !important;
    font-size: 10px !important;
    line-height: 1.4;
    color: #555;
    background-color: #dadad900 !important;
    border: 1px solid #ccc;
    box-shadow: none !important;
}
.mx-input:hover, .mx-input:focus {
    border-color: #4099ff00;
}
.mx-calendar-range {
    background-color: #5f5f5f1a;
}
.mx-calendar-content .cell:hover {
    color: #73879c;
    background-color: #c0d8ec !important;
}
</style>