<script setup>
import { characterStore, eventStore, navigationStore, searchStore } from '../../store/store.js'
</script>

<template>
	<NcAppContentList>
		<ul>
			<div class="listHeader">
				<NcTextField
					:value.sync="searchStore.search"
					:show-trailing-button="searchStore.search !== ''"
					label="Search"
					class="searchField"
					trailing-button-icon="close"
					@trailing-button-click="searchStore.setSearch('')">
					<Magnify :size="20" />
				</NcTextField>
				<NcActions>
					<NcActionButton @click="eventStore.refreshEventList()">
						<template #icon>
							<Refresh :size="20" />
						</template>
						Ververs
					</NcActionButton>
					<NcActionButton @click="eventStore.setEventItem(null); navigationStore.setModal('editEvent')">
						<template #icon>
							<Plus :size="20" />
						</template>
						Event toevoegen
					</NcActionButton>
				</NcActions>
			</div>
			<div v-if="eventStore.eventList && eventStore.eventList.length > 0">
				<NcListItem v-for="(event, i) in eventStore.eventList"
					:key="`${event}${i}`"
					:name="event?.name"
					:force-display-actions="true"
					:active="eventStore.eventItem?.id === event?.id"
					:details="getDateString(event.startDate, event.endDate)"
					:counter-number="getPlayerList(event.id).length"
					@click="eventStore.setEventItem(event)">
					<template #icon>
						<CalendarMonthOutline :class="eventStore.eventItem?.id === event.id && 'selectedZaakIcon'"
							disable-menu
							:size="44" />
					</template>
					<template #subname>
						{{ event?.description }}
					</template>
					<template #actions>
						<NcActionButton @click="eventStore.setEventItem(event); navigationStore.setModal('editEvent')">
							<template #icon>
								<Pencil />
							</template>
							Bewerken
						</NcActionButton>
						<NcActionButton @click="eventStore.setEventItem(event), navigationStore.setDialog('deleteEvent')">
							<template #icon>
								<TrashCanOutline />
							</template>
							Verwijderen
						</NcActionButton>
					</template>
				</NcListItem>
			</div>
		</ul>

		<NcLoadingIcon v-if="!eventStore.eventList"
			class="loadingIcon"
			:size="64"
			appearance="dark"
			name="Taken aan het laden" />

		<div v-if="eventStore.eventList.length === 0">
			Er zijn nog geen evenementen gedefinieerd.
		</div>
	</NcAppContentList>
</template>
<script>
// Components
import { NcListItem, NcActions, NcActionButton, NcAppContentList, NcTextField, NcLoadingIcon } from '@nextcloud/vue'

// Icons
import Magnify from 'vue-material-design-icons/Magnify.vue'
import CalendarMonthOutline from 'vue-material-design-icons/CalendarMonthOutline.vue'
import Refresh from 'vue-material-design-icons/Refresh.vue'
import Plus from 'vue-material-design-icons/Plus.vue'
import Pencil from 'vue-material-design-icons/Pencil.vue'
import TrashCanOutline from 'vue-material-design-icons/TrashCanOutline.vue'

export default {
	name: 'EventsList',
	components: {
		// Components
		NcListItem,
		NcActions,
		NcActionButton,
		NcAppContentList,
		NcTextField,
		NcLoadingIcon,
		// Icons
		CalendarMonthOutline,
		Magnify,
		Plus,
		Pencil,
		TrashCanOutline,
	},
	data() {
		return {
			charactersLoading: false,
		}
	},
	mounted() {
		eventStore.refreshEventList()
		this.fetchCharacters()
	},
	methods: {
		fetchCharacters() {
			this.charactersLoading = true
			characterStore.refreshCharacterList()
				.then(() => {
					this.charactersLoading = false
				})
		},
		getPlayerList(id) {
			// get characters related to this event
			const filteredCharacterList = characterStore.characterList.filter((character) => {
				return character.events.map(String).includes(id.toString())
			})

			return [...new Set(filteredCharacterList.map(obj => obj.ocName))]
		},
		getDateString(startDate, endDate) {
			const dates = [startDate, endDate].map((date) => {
				const dateObj = new Date(startDate)

				// Extract the month and day
				const month = String(dateObj.getUTCMonth() + 1).padStart(2, '0') // Months are zero-based
				const day = String(dateObj.getUTCDate()).padStart(2, '0')

				return `${day}/${month}`
			})

			return `${dates[0]} - ${dates[1]}`
		},
	},
}
</script>

<style>
.listHeader {
    position: sticky;
    top: 0;
    z-index: 1000;
    background-color: var(--color-main-background);
    border-bottom: 1px solid var(--color-border);
}

.searchField {
    padding-inline-start: 65px;
    padding-inline-end: 20px;
    margin-block-end: 6px;
}

.selectedIcon>svg {
    fill: white;
}

.loadingIcon {
    margin-block-start: var(--OC-margin-20);
}
</style>
