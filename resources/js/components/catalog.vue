<template>
    <div>
        <div class="d-flex pt-3">
            <div class="p-2 w-100 row">
                <label class="ml-3 font-weight-bold" for="type_select">Каталог:</label>
                <select class="custom-select ml-2" id="type_select" style="width: 200px" v-model="type_filter">
                    <option v-for="type in types" :value="type.id">{{type.chego_title}}</option>
                </select>
                <label class="ml-5 font-weight-bold" for="genre_select">Жанр:</label>
                <select class="custom-select ml-2" id="genre_select" style="width: 200px" v-model="genre_filter">
                    <option v-for="genre in genres" :value="genre.id">{{genre.rus_title}}</option>
                </select>
                <label class="ml-5 mt-1font-weight-bold" for="search">
                    <img src="/images/svg/loupe.svg" width="20" height="20">
                </label>
                <input class="form-control ml-1" type="text" v-on:input="search()" v-model="search_title" id="search" placeholder="Поиск по названию..." style="width: 200px">
            </div>
            <div class="p-2 flex-sm-shrink-1">
                <div class="btn btn-success font-weight-bold" v-on:click="filter_it()">Применить</div>
            </div>
            <div class="p-2 flex-md-shrink-1">
                <div class="btn btn-danger font-weight-bold" v-on:click="filter_it(true)">Сбросить</div>
            </div>
        </div>
    <div class="post-wrap mt-2">
        <div class="post-item" v-for="product in products">
            <div class="post-item-wrap">
                <a :href="getRoute(product.type.alias,product.id)" class="post-link">
                    <img :src="getImage(product)">
                    <div class="post-info">
                        <div class="post-meta">
                            <div class="post-date">{{product.price}} Руб.</div>
                            <div class="post-cat">{{product.type.chego_title}}</div>
                        </div>
                        <h3 class="post-title">{{product.rus_title}}</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        name: "catalog",
        props:['all_products','all_types','all_genres','all_artists'],
        data(){
            return {
                products:this.all_products,
                initialProducts:this.all_products,
                types:this.all_types,
                genres:this.all_genres,
                artists:this.all_artists,
                type_filter:'',
                genre_filter:'',
                search_title:'',
            }
        },
        mounted() {

        },
        methods:{
            getRoute(type_alias,product_id){
                return '/'+type_alias+'/'+product_id
            },
            getImage(product){
                return product.images.length>0 ? '/storage/'+product.images[0].path : '/storage/'+product.type.image
            },
            filter_it(reset=false){
                let options = {
                    type:this.type_filter,
                    genre:this.genre_filter,
                }
                if (reset){
                    options = {
                        type:'',
                        genre:'',
                    }
                }
                axios
                    .post('/catalog/filter',options)
                    .then(response => {
                        this.products = response.data.data.products//Обновление списка продуктов
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },

            search(){
                let title = this.search_title.toLowerCase()
                let products = this.initialProducts
                let filteredProducts = []
                for (let product of products){
                    if (product.title.toLowerCase().includes(title) || product.rus_title.toLowerCase().includes(title)){
                        filteredProducts.push(product)
                    }
                }
                this.products = filteredProducts
            },
        },
    }
</script>

<style scoped>

</style>
