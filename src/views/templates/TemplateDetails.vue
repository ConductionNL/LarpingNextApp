<script setup>
import { templateStore, navigationStore } from '../../store/store.js'
import DOMPurify from 'dompurify'
</script>

<template>
	<div class="detailContainer">
		<div id="app-content">
			<!-- app-content-wrapper is optional, only use if app-content-list  -->
			<div>
				<div class="head">
					<h1 class="h1">
						{{ templateStore.templateItem.name }}
					</h1>
					<NcActions :primary="true" menu-name="Acties">
						<template #icon>
							<DotsHorizontal :size="20" />
						</template>
						<NcActionButton @click="navigationStore.setModal('editTemplate')">
							<template #icon>
								<Pencil :size="20" />
							</template>
							Bewerken
						</NcActionButton>
						<NcActionButton @click="navigationStore.setDialog('deleteTemplate')">
							<template #icon>
								<TrashCanOutline :size="20" />
							</template>
							Verwijderen
						</NcActionButton>
					</NcActions>
				</div>
				<span>{{ templateStore.templateItem.description }}</span>
				<div>
					<h3>Content:</h3>
					<NcGuestContent>
						<NcRichText
							:text="DOMPurify.sanitize(templateStore.templateItem.template)"
							:autolink="true"
							:use-markdown="true" />
					</NcGuestContent>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { NcLoadingIcon, NcActions, NcActionButton, NcGuestContent, NcRichText } from '@nextcloud/vue'

import Pencil from 'vue-material-design-icons/Pencil.vue'
import TrashCanOutline from 'vue-material-design-icons/TrashCanOutline.vue'
import DotsHorizontal from 'vue-material-design-icons/DotsHorizontal.vue'

export default {
	name: 'TemplateDetails',
	components: {
		NcActions,
		NcActionButton,
		NcLoadingIcon,
		Pencil,
		TrashCanOutline,
		DotsHorizontal,
		NcGuestContent,
		NcRichText,
	},
}
</script>

<style>
h4 {
  font-weight: bold
}

.h1 {
  display: block !important;
  font-size: 2em !important;
  margin-block-start: 0.67em !important;
  margin-block-end: 0.67em !important;
  margin-inline-start: 0px !important;
  margin-inline-end: 0px !important;
  font-weight: bold !important;
  unicode-bidi: isolate !important;
}

.grid {
  display: grid;
  grid-gap: 24px;
  grid-template-columns: 1fr 1fr;
  margin-block-start: var(--zaa-margin-50);
  margin-block-end: var(--zaa-margin-50);
}

.gridContent {
  display: flex;
  gap: 25px;
}

#guest-content-vue {
    margin: 20px 5px !important;
}

</style>
