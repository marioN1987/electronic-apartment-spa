<template>
    <h3>Show all houses</h3>

    <p v-if="houses.length == 0">No houses created</p>

    <div class="houses-container">
        <div class="house" v-for="(house, index) in houses" :key="index">
            <div class="details">
                <p>House {{ index+1 }}</p>
                <p>House state: {{ house.state }}</p>
                <ul>
                    <li v-for="(floor, index) in house.floors" :key="index">
                        <p>Floor {{ index+ 1 }} has {{ floor.apartments_per_floor }} apartments, {{ floor.entrances }} entrances</p>
                    </li>
                </ul>
            </div>
            <div class="action">
                <router-link :to="{ name: 'update', params: { id: house.id }}">Update</router-link>
                <router-link :to="{ name: 'delete', params: { id: house.id }}">Delete</router-link>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .houses-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;

        > .house {
            min-width: 500px;
            border: 1px solid;
            padding: 15px;
            display: grid;
            grid-template-columns: 1fr auto;
            column-gap: 10px;

            > .details {
                > p + p {
                    margin-top: 20px;
                }
            }

            > .action {
                > a {
                    display: block;

                    & + a {
                        margin-top: 20px;
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