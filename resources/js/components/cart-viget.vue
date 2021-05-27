<template>
    <div class="row">
        <div class="cart_button p-2">
            <div class="btn btn-success font-weight-bold" v-if="amount===0" v-on:click="ajax('/cart/add')">Добавить в корзину</div>
            <div class="btn btn-danger font-weight-bold" v-if="amount>0" v-on:click="ajax('/cart/remove')">Удалить из корзины</div>
        </div>
        <div class="vidget_element p-0 ml-2 mr-2 mt-2" v-if="amount>0" v-on:click="ajax('/cart/decrease')">
            <img src="/images/svg/minus.svg" class="cart_action">
        </div>
        <div class="p-2">
            <input class="form-control form-control-sm amount font-weight-bold text-center" type="text" :value="amount" readonly>
        </div>
        <div class="vidget_element p-0 ml-2 mr-2 mt-2" v-if="amount>0" v-on:click="ajax('/cart/increase')">
            <img src="/images/svg/add.svg" class="cart_action">
        </div>
    </div>
</template>

<script>
    export default {
        name: "cart-viget",
        props: ['id',],
        data(){
            return {
                token:'',
                amount:'',
            }
        },
        mounted() {
            this.token = window.csrf_token
            let data = {id:this.id}
            axios//запрашиваем статус корзины
                .post('/cart/status',data)
                .then(response => {
                    this.amount = parseInt(response.data.data.amount)
                })
                .catch(error=>{
                    console.log(error)
                })
        },
        methods:{
            ajax(adrs){
                let options = {id:this.id}
                axios
                    .post(adrs,options)
                    .then(response => {
                        this.amount = parseInt(response.data.data.amount)
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },
        },
    }
</script>

<style scoped>

</style>
