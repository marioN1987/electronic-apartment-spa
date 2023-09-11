<template>
    <div class="delete-house-section" v-if="loaded">
        <h4 v-if="success">House successfully deleted</h4>
        <h2>Delete House {{ houseId }}</h2>
        <p>House state: {{ house.selected_state_name }}</p>
        <p>Floors no: {{ countFloors }}</p>
        <div class="floors-container">
            <div class="floor" v-for="(floor, index) in house.floors" :key="index">
                <p v-if="floor.apartments_per_floor !== 0 || floor.entrances !== 0">Floor {{ index+ 1 }}: apartments: {{ floor.apartments_per_floor }}, entrances: {{ floor.entrances }}</p>
            </div>
        </div>
        <button @click="submit()">Delete</button>
    </div>
</template>
 
<style lang="scss" scoped>
    .delete-house-section {
        padding: 20px;
        max-width: 500px;

        p + p {
            margin-top: 10px;
        }

        > .floors-container {
            padding-top: 25px;

            > .floor + .floor {
                margin-top: 10px;
            }
        }

        > button {
            margin-top: 20px;
        }
    }
</style>

<script>

export default {
    data() {
        return {
            houseId: this.$route.params.id,
            loaded: false,
            success: false,
            house: []
        }
    },

    computed: {
        countFloors() {
            return this.house.floors.filter(prop => prop.apartments_per_floor !== 0 || prop.entrances !== 0).length;
        },
    },

    methods: {
        submit() {
            axios.post(`/delete-house/${this.houseId}`)
                .then((response)=>{
                    if (response.status == 200) {
                        this.success = true;
                    }
                }).catch((error) => { 
                    if (error) {
                        console.log(error);
                    }  
                });
        },

        loadHouse() {
            axios.get(`/load-house/${this.houseId}`)
                .then((response)=>{
                    this.house = response.data.house;
                    this.loaded = true;
                }).catch((error) => { 
                    if (error) {
                        console.log(error);
                    }  
                });
        }
    },

    mounted() {
        this.loadHouse();
    }
}

</script>