<template>
    <div class="update-house-section">
        <h2>Update house {{ houseId }}</h2>
        <h4 v-if="success">House successfully updated</h4>

        <div class="form-errors" v-if="errors">
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>

        <div class="form-group" :class="{'invalid': !stateSelected && showErrors}">
            <label>Select house state (required)</label>
            <select v-model="stateSelected">
                <option v-for="option in states" :key="option.id" :value="option.id">
                    {{ option.name }}
                </option>
            </select>
        </div>
        <div class="floor-container">
            <div class="form-group-wrapper" v-for="(floor, index) in floors" :key="index">
                <div class="form-group" :class="{'invalid': !floor.apartments_no && showErrors }">
                    <label> Floor {{ index+1 }} apartments {{ (index < 2) ? '(required)' : null }}</label>
                    <p class="not-in-range" v-if="floor.notInRange">Apartments number should be between 1 and 4</p>
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
            states: [],
            houseId: this.$route.params.id,
            house: [],
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
        resetVariables() {
            this.stateSelected = null;
            this.floors.forEach(floor => {
                for (const [,] of Object.entries(floor)) {
                    floor.apartments_no = null;
                    floor.entrances = null;
                }
            });
        },

        fillFloorsObjArr() {
            this.house.floors.forEach((floorObj, index) => {
                this.floors[index].id = floorObj['id'];
                this.floors[index].apartments_no = floorObj['apartments_per_floor'];
                this.floors[index].entrances = floorObj['entrances'];
            });
        },

        deleteNotInRangeAndZeroEmptyValues() {
            this.floors.forEach(floor => {
                for (const [key, value] of Object.entries(floor)) {
                    delete floor.notInRange;

                    if (floor.apartments_no == "") {
                        floor.apartments_no = 0;
                    }

                    if (floor.entrances == "") {
                        floor.entrances = 0;
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

            this.deleteNotInRangeAndZeroEmptyValues();

            this.showErrors = false;

            const data = {
                'house_id': this.houseId,
                'house_state': this.stateSelected,
                'floors': this.floors
            };

            axios.post('/update-house', data)
                .then((response) => {
                    if (response.status == 200) {
                        this.success = true;
                        this.resetVariables();
                    }
                }).catch((error) => {
                    if (error) {
                        let index = 0;
                        for (const [key, value] of Object.entries(error.response.data.error)) {
                            for (const [key1, value1] of Object.entries(value)) {
                            let temp = value1;
                                if (temp.includes('apartments_no')) {
                                    temp = temp.replace(`floors.${index}.apartments_no`, `floor ${index+1} apartments no`);
                                } else if (temp.includes('entrances')) {
                                    temp = temp.replace(`floors.${index}.entrances`, `floor ${index+1} entrances no`);
                                }
                                this.errors.push(temp);
                                index++;   
                            }
                        }
                    }
                });
        },

        loadHouse() {
            axios.get(`/load-house/${this.houseId}`)
                .then((response)=>{
                    this.house = response.data.house;
                    this.stateSelected = this.house.selected_state_id;
                    this.states = this.house.states;
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