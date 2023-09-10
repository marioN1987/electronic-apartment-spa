<template>
    <div class="show-all-houses">
        <h3>Show all houses</h3>
        <p v-if="houses.length == 0">No houses created</p>
        <div class="houses-container">
            <div class="house" v-for="(house, index) in houses" :key="index">
                <div class="details">
                    <p class="bold">House {{ index + 1 }}</p>
                    <p>House state: {{ house.state }}</p>
                    <p>Floors no: {{ countFloors(index) }}</p>
                    <div class="floors-container">
                        <div class="floor" v-for="(floor, index) in house.floors" :key="index">
                            <p v-if="floor.apartments_per_floor !== 0 || floor.entrances !== 0">Floor {{ index+ 1 }}: apartments: {{ floor.apartments_per_floor }}, entrances: {{ floor.entrances }}</p>
                        </div>
                    </div>
                </div>
                <div class="action">
                    <ul class="hover-effect">
                        <li>
                            <router-link :to="{ name: 'update', params: { id: house.id }}">Update</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'delete', params: { id: house.id }}">Delete</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.show-all-houses {
    padding: 20px;
    > .houses-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;

        > .house {
            min-width: 500px;
            background-color: aliceblue;
            border-radius: 8px;
            padding: 15px;
            display: grid;
            grid-template-columns: 1fr auto;
            column-gap: 10px;

            > .details {
                > .floors-container {
                    margin-top: 15px;
                    > .floor {
                        padding: 10px 0px;
                    }
                }

                > p + p {
                    margin-top: 10px;
                }
            }
        }
    }

}
</style>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                houses: []
            }
        },

        methods: {
            countFloors(index) {
                return this.houses[index].floors.filter(prop => prop.apartments_per_floor !== 0 || prop.entrances !== 0).length;
            },

            loadHouses() {
                axios.get('/list')
                    .then((response)=>{
                        this.houses = response.data.houses;
                    }).catch((error) => { 
                        if (error) {
                            console.log(error);
                        }  
                    });
            }
        },

        mounted() {
            this.loadHouses();
        }
    }
</script>