<script setup>
import axios from 'axios';
import { ref } from 'vue';

const options = ref([
  { text: 'Planning', value: '1' },
  { text: 'In Design', value: '2' },
  { text: 'Under Construction', value: '3' },
  { text: 'Ready', value: '4' }
]);

</script>

<template>
    <div class="update-house-section">
        <h2 v-if="success">House successfully updated</h2>

        <!-- <div class="form-errors" v-if="errors">
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div> -->
        <div class="form-group" :class="{'invalid': !stateSelected && showErrors}">
            <label>Select house state (required)</label>
            <select v-model="stateSelected">
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.text }}
                </option>
            </select>
        </div>
        <div class="floor-container">
            <div class="form-group-wrapper" v-for="(floor, index) in floors" :key="index">
                <div class="form-group" :class="{'invalid': !floor.apartments_no && showErrors }">
                    <label> Floor {{ index+1 }} apartments {{ (index < 2) ? '(required)' : null }}</label>
                    <p class="not-in-range" v-if="floor.notInRange">Apartments number should be between 1 and 10</p>
                    <input type="number" v-model="floor.apartments_no" placeholder="Enter floor apartments no"/>
                </div>
                <div class="form-group" :class="{'invalid': !floor.entrances && showErrors }">
                    <label>Floor {{ index+1 }} entrances {{ (index < 2) ? '(required)' : null }}</label>
                    <input type="number" v-model="floor.entrances" placeholder="Entrances per floor"/>
                </div>
            </div>
        </div>
        <button class="submit-btn" @click="submit()">Update</button>
    </div>
</template>

<style lang="scss" scoped>

    // Update SECTION
    .update-house-section {
        max-width: 1000px;
        margin: 50px auto;

        > .floor-container 
        > .form-group-wrapper
        > .form-group,
        > .form-group {
            display: flex;
            flex-direction: column;
            row-gap: 10px;
            margin-top: 20px;
            
            > .not-in-range {
                font-style: italic;
            }

            > label {
                font-weight: bold;
            }

            &.invalid {
                > label {
                    color: red;
                }
            }

            input,
            select {
                padding: 5px;
            }
        }

        > .submit-btn {
            margin-top: 20px;
        }
    }

</style>

<script>
export default {
    data() {
        return {
            stateSelected: null,
            houseId: this.$route.params.id,
            house: {},
            floors: [
                {
                    id: null,
                    apartments_no: null,
                    notInRange: false,
                    entrances: null
                },
                {
                    id: null,
                    apartments_no: null,
                    notInRange: false,
                    entrances: null
                },
                {
                    id: null,
                    apartments_no: null,
                    notInRange: false,
                    entrances: null
                },
                {
                    id: null,
                    apartments_no: null,
                    notInRange: false,
                    entrances: null
                }
            ],
            errors: [],
            showErrors: false,
            success: false
        }
    },

    computed: {
        isValid() {
            return this.stateSelected && 
                    this.floors[0].apartments_no &&
                    this.floors[0].entrances && 
                    this.floors[1].apartments_no &&  
                    this.floors[1].entrances;
        },

        checkApartmentsNoInRange() {
            let inRange = true;
            
            this.floors.forEach(floor => {
                for (const [key, value] of Object.entries(floor)) {
                    if (key === 'apartments_no') {
                        if (floor[key] && (floor[key] < 1 || floor[key] > 4)) {
                            inRange = false;
                            floor.notInRange = true;
                            floor.apartments_no = null;
                        }
                    }
                }
            })
    
            return inRange;
        }
    },  

    methods: {
        fillFloorsObjArr() {
            this.house.floors.forEach((floorObj, index) => {
                this.floors[index].id = floorObj['id'];
                this.floors[index].apartments_no = floorObj['apartments_per_floor'];
                this.floors[index].entrances = floorObj['entrances'];
            });
        },

        deleteNotInRangeAndNullKeys() {
            this.floors.forEach(floor => {
                for (const [key, value] of Object.entries(floor)) {
                    delete floor.notInRange;
                    if (!value) {
                        delete floor[key];
                    }
                }
            });
        },

        submit() {
            if (!this.isValid) {
                this.showErrors = true;
                return;
            }

            if (!this.checkApartmentsNoInRange) {
                return;
            }

            this.showErrors = false;

            this.deleteNotInRangeAndNullKeys();

            console.log(this.floors);

            const data = {
                'house_id': this.houseId,
                'house_state': this.stateSelected,
                'floors': this.floors
            };

            axios.post('/update-house', data)
                .then((response) => {
                    console.log(response);
                    if (response.status == 200) {
                        this.success = true;
                        //this.$router.push('home');
                    }
                }).catch((error) => {
                    console.log(error);
                });
        },

        loadHouse() {
            axios.get(`/load-house/${this.houseId}`)
                .then((response)=>{
                    this.house = response.data.house;
                    this.stateSelected = this.house.state_id;
                    this.fillFloorsObjArr();
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