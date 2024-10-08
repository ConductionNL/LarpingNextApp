/* eslint-disable no-console */
import { defineStore } from 'pinia'
import { Effect } from '../../entities/index.js'

export const useEffectStore = defineStore(
	'effect', {
		state: () => ({
			effectItem: false,
			effectList: [],
		}),
		actions: {
			// Set the active effect item
			setEffectItem(effectItem) {
				this.effectItem = effectItem && new Effect(effectItem)
				console.log('Active effect item set to ' + effectItem)
			},
			// Set the list of effects
			setEffectList(effectList) {
				this.effectList = effectList.map(
					(effectItem) => new Effect(effectItem),
				)
				console.log('Effect list set to ' + effectList.length + ' items')
			},
			// Fetch and refresh the list of effects
			async refreshEffectList(search = null) {
				let endpoint = '/index.php/apps/larpingapp/api/effects'
				if (search !== null && search !== '') {
					endpoint = endpoint + '?_search=' + search
				}
				try {
					const response = await fetch(endpoint, { method: 'GET' })
					const data = await response.json()
					this.setEffectList(data.results)
				} catch (err) {
					console.error(err)
				}
			},
			// Fetch a single effect by ID
			async getEffect(id) {
				const endpoint = `/index.php/apps/larpingapp/api/effects/${id}`
				try {
					const response = await fetch(endpoint, { method: 'GET' })
					const data = await response.json()
					this.setEffectItem(data)
					return data
				} catch (err) {
					console.error(err)
					throw err
				}
			},
			// Delete an effect by ID
			deleteEffect() {
				if (!this.effectItem || !this.effectItem.id) {
					throw new Error('No effect item to delete')
				}

				console.log('Deleting effect...')

				const endpoint = `/index.php/apps/larpingapp/api/effects/${this.effectItem.id}`

				return fetch(endpoint, {
					method: 'DELETE',
				})
					.then((response) => {
						this.refreshEffectList()
					})
					.catch((err) => {
						console.error('Error deleting effect:', err)
						throw err
					})
			},
			// Create or update an effect
			saveEffect(effectItem) {
				if (!effectItem) {
					throw new Error('No effect item to save')
				}

				console.log('Saving effect...')

				const isNewEffect = !effectItem.id
				const endpoint = isNewEffect
					? '/index.php/apps/larpingapp/api/effects'
					: `/index.php/apps/larpingapp/api/effects/${effectItem.id}`
				const method = isNewEffect ? 'POST' : 'PUT'

				return fetch(
					endpoint,
					{
						method,
						headers: {
							'Content-Type': 'application/json',
						},
						body: JSON.stringify(effectItem),
					},
				)
					.then((response) => response.json())
					.then((data) => {
						this.setEffectItem(data)
						console.log('Effect saved')
						return this.refreshEffectList()
					})
					.catch((err) => {
						console.error('Error saving effect:', err)
						throw err
					})
			},
		},
	},
)
