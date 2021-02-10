<template>
    <div class=" mt-5 px-4 ">
          <div v-if="cart.items.length == 0"> NON HAI NESSUN ORDINE</div>
        <table v-else class= " shadow sm:rounded-lg table-auto ">
            <thead class= 'border border-red-700'>
                <tr class="text-center bg-red-600  ">
                    <th scope="col" class="px-6 py-3 text-center text-md font-medium text-gray-100 uppercase tracking-wider">
                        Dimensione
                    </th>
                    <th class="px-6 py-3 text-center text-md font-medium text-gray-100 uppercase tracking-wider">
                        Impasto
                    </th>
                    <th class="px-6 py-3 text-center text-md font-medium text-gray-100 uppercase tracking-wider">
                        Ingredienti
                    </th>
                    <th class="px-6 py-3 text-center text-md font-medium text-gray-100 uppercase tracking-wider">
                        Prezzo
                    </th>
                </tr>
            </thead>
            <tbody class= 'border border-gray-300'>
                <tr class= 'border border-b-2 border-grey-500 bg-white' v-for="item in cart.items" :key="item.typeId">
                    <td class = "px-2 py-4  whitespace-nowrap   font-medium">
                        {{item.sizeName}}
                    </td>
                    <td class = "px-2 py-4  whitespace-nowrap   font-medium">
                        {{item.typeName}}
                    </td>
                    <td class = "px-2 py-4  font-medium">
                        <span v-for="ingredient in item.ingredients" :key="ingredient.id"> {{ ingredient.name}} </span>
                    </td>
                    <td class = "px-2 py-4  whitespace-nowrap   font-medium">
                        {{item.price}} €
                    </td>
                </tr>

                <tr class="bg-gray-200">
                    <td colspan="3"></td>
                    <td class = "px-2 py-4 flex justify-end items-center whitespace-nowrap   font-medium">
                        <strong class="px-6 text-sm">PREZZO TOTALE : {{ cartTotal}} €</strong> 
                        <a class="btn" @click="sendMessage()">COMPRA ORA</a>
                    </td>
                </tr>

            </tbody>
        
        </table>
    </div>
</template>

<script>
export default {
    props : [
        'cart'
    ],
    computed: {
        cartTotal: function() {
            var total =  0;
            this.cart.items.forEach(function(item) {
                total += item.price
            });
            return total;
        }
    },
    methods: {
        sendMessage() {

            axios.post('/pizzabuilder/sendOrder', {
                order: this.cart.items,
                
                total_price : this.cartTotal
            })
                .then( response => {
                    
                    if(response.status == 201) {
                        this.cart.items = [];                    
                    }
                })
                .catch( error => {

                    console.log(error);
                })         
        },
    },
}
</script>

<style  scoped>

    table {
     width: 100%;
     text-align: center;
 }

    .btn {
        background-color: crimson;
        padding: 5px;
        border-radius: 3px;
        color: white;
        float: right;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn:hover {
        
        background-color: rgb(187, 19, 52);
        box-shadow: 1px 1px 3px black;

    }
</style>