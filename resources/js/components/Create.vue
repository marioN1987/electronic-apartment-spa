<template>
    <div class="create-house-section">
        <h2>Create new house</h2>
        <h4 v-if="success">House successfully created</h4>
        
        <div class="form-errors" v-if="errors.length > 0">
            <h4>Form errors</h4>
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>

        <div class="form-group" :class="{'invalid': !stateSelected && showErrors}">
            <label>Select house state (required)</label>
            <select v-model="stateSelected">
                <option selected value="">Please select state ...</option>
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
        <button class="submit-btn" @click="submit()">Create</button>
    </div>
</template>

<style lang="scss" scoped>

    // CREATE SECTION
    .create-house-section {
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
            stateSelected: "",
            states: [],
            floors: [
                {
                    apartments_no: null,
                    notInRange: false,
                    entrances: null
                },
                {
                    apartments_no: null,
                    notInRange: false,
                    entrances: null
                },
                {
                    apartments_no: 0,
                    notInRange: false,
                    entrances: 0
                },
                {
                    apartments_no: 0,
                    notInRange: false,
                    entrances: 0
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
                        if (floor[key] && (floor[key] <= 0 || floor[key] > 4)) {
                            inRange = false;
                            floor.notInRange = true;
                            floor.apartments_no = null;
                        }
                    }
                }
            })
    
            return inRange;
        },
    },

    methods: {
        zeroEmptyValues() {
            this.floors.forEach(floor => {
                for (const [,] of Object.entries(floor)) {
                    if (floor.apartments_no == "") {
                        floor.apartments_no = 0;
                    }

                    if (floor.entrances == "") {
                        floor.entrances = 0;
                    }
                }
            });
        },

        resetVariables() {
            this.stateSelected = null;
            this.floors.forEach(floor => {
                for (const [,] of Object.entries(floor)) {
                    floor.apartments_no = null;
                    floor.entrances = null;
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

            this.zeroEmptyValues();

            this.showErrors = false;

            const data = {
                'house_state': this.stateSelected,
                'floors': this.floors
            };

            axios.post('create-house',data)
                .then((response) => {
                    if (response.status == 200) {
                        this.success = true;
                        this.resetVariables();
                    }
                }).catch((error) => {
                    if (error) {
                        for (const [key, value] of Object.entries(error.response.data.errors)) {
                            for (const [key1, value1] of Object.entries(value)) {
                                let errorStr = value1.replace(/(\d+)+/g, function(match, number) { return parseInt(number)+1; });
                                this.errors.push(errorStr);
                            }
                        }
                    }
                });
        },

        getStates() {
            axios.get('/get-states')
                    .then((response)=>{
                        this.states = response.data.states;
                    }).catch((error) => { 
                        if (error) {
                            console.log(error);
                        }  
                    });
        }
    },

    mounted() {
        this.getStates();
    }
}

</script>