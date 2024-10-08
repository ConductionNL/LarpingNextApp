import { Character } from './character'
import { TCharacter } from './character.types'

export const mockCharacterData = (): TCharacter[] => [
	{
		id: '5137a1e5-b54d-43ad-abd1-4b5bff5fcd3f',
		name: 'Evil Kenevil',
		ocName: '1',
		description: 'A daredevil stuntman known for his death-defying motorcycle jumps.',
		background: 'Evil Kenevil grew up in a circus family, developing a passion for thrills and danger from a young age.',
		itemsAndMoney: 'Customized motorcycle, leather jumpsuit, helmet, 50 gold pieces',
		notice: '',
		faith: 'Believes in the god of risk and adventure',
		slNotesPublic: 'Known for attempting increasingly dangerous stunts',
		slNotesPrivate: 'Has a secret fear of heights, compensates with bravado',
		card: '| Evil Kenevil | Daredevil Stuntman |\n|---------------|--------------------|\n| Strength: 14  | Dexterity: 18      |\n| Charisma: 16  | Intelligence: 12   |',
		stats: [],
		gold: 50,
		silver: 0,
		copper: 0,
		events: [],
		skills: [],
		conditions: [],
		type: 'player',
		approved: 'approved',
	},
	{
		id: '4c3edd34-a90d-4d2a-8894-adb5836ecde8',
		name: 'Jack the Dipper',
		ocName: '1',
		description: 'A skilled pickpocket with a heart of gold, known for his quick hands and quicker wit.',
		background: 'Orphaned at a young age, Jack learned to survive on the streets by mastering the art of theft.',
		itemsAndMoney: 'Set of lockpicks, dark cloak, 30 silver pieces',
		notice: '',
		faith: 'Follows the trickster god',
		slNotesPublic: 'Often seen helping the poor despite his criminal activities',
		slNotesPrivate: 'Secretly wants to retire and open an orphanage',
		card: '| Jack the Dipper | Master Thief |\n|-----------------|---------------|\n| Agility: 18     | Stealth: 16    |\n| Charisma: 15    | Luck: 14       |',
		stats: [],
		gold: 0,
		silver: 30,
		copper: 0,
		events: [],
		skills: [],
		conditions: [],
		type: 'player',
		approved: 'approved',
	},
	{
		id: '15551d6f-44e3-43f3-a9d2-59e583c91eb0',
		name: 'Piet Piraat',
		ocName: '1',
		description: 'A jovial pirate captain with a penchant for singing sea shanties and hunting for buried treasure.',
		background: 'Piet was born on a ship and has spent his entire life at sea, working his way up from cabin boy to captain.',
		itemsAndMoney: 'Cutlass, spyglass, treasure map, 100 gold pieces',
		notice: '',
		faith: 'Worships the sea goddess',
		slNotesPublic: 'Known for his fairness in dividing loot among the crew',
		slNotesPrivate: 'Has a crippling fear of mermaids due to a childhood incident',
		card: '| Piet Piraat | Pirate Captain |\n|-------------|------------------|\n| Strength: 16 | Navigation: 18   |\n| Charisma: 17 | Seamanship: 19   |',
		stats: [],
		gold: 100,
		silver: 0,
		copper: 0,
		events: [],
		skills: [],
		conditions: [],
		type: 'player',
		approved: 'approved',
	},
	{
		id: '0a3a0ffb-dc03-4aae-b207-0ed1502e60da',
		name: 'Sonja de rovers dochter',
		ocName: '1',
		description: 'A fierce warrior woman, raised by bandits but with a strong sense of justice.',
		background: 'Sonja was kidnapped as a child and raised by a band of robbers, but always felt drawn to heroic deeds.',
		itemsAndMoney: 'Longbow, short sword, leather armor, 75 silver pieces',
		notice: '',
		faith: 'Follows the path of the righteous warrior',
		slNotesPublic: 'Often conflicts with authority due to her unconventional upbringing',
		slNotesPrivate: 'Secretly searching for her birth parents',
		card: '| Sonja de rovers dochter | Bandit Turned Hero |\n|---------------------------|---------------------|\n| Strength: 15              | Archery: 18         |\n| Agility: 16               | Survival: 17        |',
		stats: [],
		gold: 0,
		silver: 75,
		copper: 0,
		events: [],
		skills: [],
		conditions: [],
		type: 'player',
		approved: 'no',
	},
]

export const mockCharacter = (data: TCharacter[] = mockCharacterData()): TCharacter[] => data.map(item => new Character(item))
