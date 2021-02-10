<template>
<app-layout>
        <template #header >
            <div class="flex justify-between justify-items-center">               
                <h2 v-if="!isShowingCart" class=" font-mono font-semibold text-3xl text-gray-800 leading-tight ">
                    CREA LA TUA PIZZA
                </h2>
                <h2 v-else class="font-mono font-semibold text-3xl text-gray-800 leading-tight ">
                    IL TUO ORDINE
                </h2>
                <a v-if="!isShowingCart" class="btn" @click="isShowingCart = true">IL TUO ORDINE <font-awesome-icon icon="shopping-cart" /> ({{ cart.items.length  }})</a>
                <a v-else class="btn" @click="isShowingCart = false">TORNA INDIETRO</a>
            </div>
        </template>

        <div v-if="!isShowingCart" vclass=" container-fluid m-4 ">
            <div class=" relative wood bg-white mx-4 mt-5 relative flex justify-center justify-items-center border border-red-600 p-3">
                <img  class="pala " :src="'img/pala_pizza.png'" alt="">
                <div class="relative">
                    <img  style='width: 300px' :src="'img/pizza.png'">
                    <img v-if="selectedIngredientsId.includes(5)" class="ingredients-layer" :src="'img/salamino.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(7)" class="ingredients-layer" :src="'img/peperoni.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(3)" class="ingredients-layer" :src="'img/prosciutto.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(4)" class="ingredients-layer" :src="'img/funghi.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(6)" class="ingredients-layer" :src="'img/scamorza.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(8)" class="ingredients-layer" :src="'img/cipolle.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(1)" class="ingredients-layer" :src="'img/olive.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(2)" class="ingredients-layer" :src="'img/patatine.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(9)" class="ingredients-layer" :src="'img/salsiccia.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(10)" class="ingredients-layer" :src="'img/zola.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(11)" class="ingredients-layer" :src="'img/wurstel.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(12)" class="ingredients-layer" :src="'img/carciofi.png'" alt="">
                    <img v-if="selectedIngredientsId.includes(13)" class="ingredients-layer" :src="'img/prosciutto_crudo.png'" alt="">
                </div>
                <div class="p-4 price-wrapper">
                    <div  class="text-center mb-4">
                        <strong>PREZZO: {{totalPrice}} €</strong> 
                    </div>
                
                    <div >
                        <button @click="addToCart()" class="btn">AGGIUNGI ALL'ORDINE</button>
                    </div>
                </div>
            </div>
            <div class="  bg-gray-100 m-4 grid grid-cols-1 md:grid-cols-3  border-2 border-red-600 px-4 py-2">

                <div class="border-r-2 px-2 ">
                    <h2 class="text-xl text-center font-mono pb-2">SCEGLI LA GRANDEZZA</h2>

                    <div v-for="(size, index) in sizes" :key="index" >
                        <input @change="addSizePrice(size)" type="radio" name="size" value="size.id">
                        <label for="size.id">{{size.name}}</label><br>
                    </div>
                </div>

                <div class="border-r-2 px-4">

                    <h2 class="text-xl text-center font-mono pb-2">SCEGLI L'IMPASTO</h2>

                    <div v-for="(type, index) in types" :key="index" >
                        <input @change="addTypePrice(type)" type="radio" name="type" value="type.id">
                        <label for="type.id">{{type.name}}</label><br>
                    </div>

                </div>
                <div class="px-4 h-full">
                    <h2 class="text-xl text-center font-mono pb-2">SCEGLI GLI INGREDIENTI</h2>
                    <div class="flex flex-column flex-wrap">
                        <div class="w-3/6" v-for="(ingredient, index) in ingredients" :key="index" >
                            <input @click="addIngredientPrice(ingredient, $event)"  type="checkbox" name="" value="ingredient.id">
                            <label for="ingredient.id"> {{ingredient.name}}</label><br>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div v-else>
        <cart       
        :cart = "cart">

        </cart>
        </div>
    </app-layout>
    
</template>

<script>
    

    import AppLayout from '@/Layouts/AppLayout';
    import cart from './Cart.vue';

export default {

    components: {
        AppLayout,
        cart
    },
    data() {
        return {

            isShowingCart : false,


            ingredients: [],
            sizes : [],
            types : [],
            inputs : [],
            

            sizePrice: 0,
            selectedSizeId: '',
            selectedSizeName: '',

            typePrice: 0,
            selectedTypeId: '',
            selectedTypeName: '',

            ingredientPrice: 0, 
            selectedIngredients: [],
            selectedIngredientsId: [],

            totalPrice: 0,
            cart: {
                items: []
            },
            
           
        }
    },
    methods: {
        getElements() {
            axios.get('/pizzabuilder/elements')
                .then( response => {
                    
                    this.ingredients = (response.data[0]);
                    this.sizes = (response.data[1]);
                    this.types = (response.data[2]);
                })
                .catch( error => {
                    console.log(error);
                })         
        }, 
        addSizePrice(obj) {
            this.sizePrice = parseFloat(obj.price) ;
            this.selectedSizeId = obj.id;
            this.selectedSizeName = obj.name;
            this.getTotal();
        },

        addTypePrice(obj) {
            this.typePrice = parseFloat(obj.price) ;
            this.selectedTypeId = obj.id;
            this.selectedTypeName = obj.name;
            this.getTotal();           
        },  

        addIngredientPrice(obj, event) {
            
            if(event.target.checked) {
                this.ingredientPrice =this.ingredientPrice + parseFloat(obj.price) ;
                this.selectedIngredients.push(obj);
                this.selectedIngredientsId.push(obj.id);
            } else {
                this.ingredientPrice =this.ingredientPrice - parseFloat(obj.price) ;
                this.selectedIngredients.splice(this.selectedIngredients.indexOf(obj), 1);
                this.selectedIngredientsId.splice(this.selectedIngredientsId.indexOf(obj), 1);
                
            }
            this.getTotal();          
        },   
        
        getTotal() {
            this.totalPrice = this.sizePrice + this.typePrice + this.ingredientPrice;
            
        },
        addToCart() {
            this.cart.items.push({
                sizeId:this.selectedSizeId,
                typeId : this.selectedTypeId,
                typeName : this.selectedTypeName,
                sizeName : this.selectedSizeName,
                price : this.totalPrice,
                ingredients : this.selectedIngredients
            });
            this.sizePrice = 0;
            this.ingredientPrice = 0;
            this.typePrice = 0;
            this.totalPrice = 0;
            this.selectedIngredients = [];
            this.selectedIngredientsId = [];
            this.inputs = document.getElementsByTagName('input');

            for(var i = 0; i<this.inputs.length; i++){
                this.inputs[i].checked = false;

            }
           
            console.log(this.inputs);
            console.log(this.cart.items);
        }
    },
    created() {
        this.getElements();
        
    },

}
</script>

<style scoped>
    .btn {
        background-color: crimson;
        padding: 5px;
        border-radius: 3px;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn:hover {
    
    background-color: rgb(187, 19, 52);
    box-shadow: 1px 1px 3px black;

    }

    h2 {
        color: crimson;
        font-weight: bold;
    }

    .price-wrapper {
        background-color: whitesmoke;
        position: absolute;
        bottom: 0;
        right: 0;
        border-left: 2px solid crimson;
        border-top: 2px solid crimson;
        border-right: 1px solid crimson;
        border-bottom: 1px solid crimson;
    }
    .ingredients-layer {
        position: absolute;
        top: 0;
        left: 0;
    }
    .wood {
        background-image: url('https://images.unsplash.com/photo-1495195129352-aeb325a55b65?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1355&q=80');
    }
    .pala{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;

    }
   
</style>