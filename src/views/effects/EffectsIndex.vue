<script setup>
import { store } from '../../store.js'
</script>

<template>
	<NcAppContent>
		<template #list>
			<EffectsList />
		</template>
		<template #default>
			<NcEmptyContent v-if="!store.effectItem || !store.effectItem.id || store.selected != 'effects' "
				class="detailContainer"
				name="Geen effect"
				description="Nog geen effect geselecteerd">
				<template #icon>
					<MagicStaff />
				</template>
				<template #action>
					<NcButton type="primary" @click="store.setModal('addEffect')">
						Effect toevoegen
					</NcButton>
				</template>
			</NcEmptyContent>
			<EffectDetails v-if="store.effectItem && store.effectItem.id && store.selected === 'effects'" />
		</template>
	</NcAppContent>
</template>

<script>
import { NcAppContent, NcEmptyContent, NcButton } from '@nextcloud/vue'
import EffectsList from './EffectsList.vue'
import EffectDetails from './EffectDetails.vue'
// eslint-disable-next-line n/no-missing-import
import MagicStaff from 'vue-material-design-icons/MagicStaff'

export default {
	name: 'EffectsIndex',
	components: {
		NcAppContent,
		NcEmptyContent,
		NcButton,
		EffectsList,
		EffectDetails,
		MagicStaff,
	},
	data() {
		return {
			activeMetaData: false,
			klantId: undefined,
		}
	},
}
</script>
