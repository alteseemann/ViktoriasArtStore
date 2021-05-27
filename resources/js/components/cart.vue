<template>
<div class="mt-3">
    <div v-if="products.length>0">
        <table class="table border border-dark">
            <thead class="thead-dark">
            <tr>
                <th>№</th>
                <th>Изображение</th>
                <th>Описание</th>
                <th>Количество</th>
                <th>Цена</th>
                <th class="text-center">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <!--Список товаров-->
            <tr v-for="product in products">
                <th scope="row">{{products.indexOf(product)+1}}</th>
                <td>
                    <img :src="setPath(product[2])" width="100" height="100" style="object-fit: cover" class="border border-dark">
                </td>
                <td class="text-justify">{{product[3]}}</td>
                <td>
                    <div class="row justify-content-center ml-1">
                        <div style="width: 33%; cursor: pointer" v-on:click="decrease(product[0])" class="text-dark font-weight-bold">
                            -
                        </div>
                        <div style="width: 33%">
                            {{product[1]}}
                        </div>
                        <div style="width: 33%; cursor: pointer" v-on:click="increase(product[0])" class="text-dark font-weight-bold">
                            +
                        </div>
                    </div>
                </td>
                <td style="width: 100px">{{product[4]}} Р</td>
                <td class="text-center">
                    <img src="images/svg/remove.svg" width="20" height="20" v-on:click="remove(product[0])" style="cursor: pointer">
                </td>
            </tr>
            <!--Список товаров-->
            </tbody>
        </table>
        <div class="d-flex flex-row-reverse">
            <a class="btn btn-success font-weight-bold" href="/cart/order/blank">Оформить заказ</a>
        </div>
    </div>

    <div v-if="products.length === 0" class="p-2 font-weight-bold text-dark bg-info" style="border-radius: 4px">
        В корзине пока нет товаров
    </div>
</div>
</template>

<script>
    export default {
        name: "cart",
        props: [],
        data(){
            return {
                products:{},
                path:'',
            }
        },
        mounted() {
            this.getProducts()
        },
        methods:{
            ajax(adrs,id){
                let options = {id:id}
                axios
                    .post(adrs,options)//запрос на действие с корзиной
                    .then(response => {
                        this.getProducts()//Обновление списка продуктов
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },
            getProducts(){//Функция обновляет список продуктов в корзине
                axios
                    .post('cart/get_products')
                    .then(response => {
                        this.products = response.data.data.products
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },
            setPath(path){
                return path
            },
            increase(id){
                this.ajax('/cart/increase',id)
            },
            decrease(id){
                this.ajax('/cart/decrease',id)
            },
            remove(id){
                this.ajax('/cart/remove',id)
            },
            showModal(id){
                $(id).modal()
            },
        },
    }
</script>

<style scoped>

</style>
