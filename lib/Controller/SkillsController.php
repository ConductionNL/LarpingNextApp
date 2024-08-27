<?php

namespace OCA\LarpingApp\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use OCA\LarpingApp\Service\ObjectService;
use OCA\LarpingApp\Service\SearchService;
use OCA\LarpingApp\Db\Skill;
use OCA\LarpingApp\Db\SkillMapper;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IAppConfig;
use OCP\IRequest;

class SkillsController extends Controller
{
    const TEST_ARRAY = [
        [
            "id" => "5137a1e5-b54d-43ad-abd1-4b5bff5fcd3f",
            "name" => "Healing LvL 1",
            "description" => "Healers are what keeps the party going, when someone goes down a healer makes sure they get back up again.",
            "effect" => "Character has access to level 1 healing spells",
            "effects" => [],
            "requiredSkills" => [],
            "requiredStats" => [],
            "requiredConditions" => [],
            "requiredEffects" => [],
            "requiredScore" => 10
        ],
        [
            "id" => "4c3edd34-a90d-4d2a-8894-adb5836ecde8",
            "name" => "Swordsmanship",
            "description" => "Masters of the blade, swordsmen are deadly in close combat and can turn the tide of battle.",
            "effect" => "Character gains +2 to attack rolls with swords",
            "effects" => [],
            "requiredSkills" => [],
            "requiredStats" => [],
            "requiredConditions" => [],
            "requiredEffects" => [],
            "requiredScore" => 12
        ],
        [
            "id" => "15551d6f-44e3-43f3-a9d2-59e583c91eb0",
            "name" => "Arcane Knowledge",
            "description" => "Those versed in arcane knowledge can unravel the mysteries of magic and harness its power.",
            "effect" => "Character can identify magical items and effects",
            "effects" => [],
            "requiredSkills" => [],
            "requiredStats" => [],
            "requiredConditions" => [],
            "requiredEffects" => [],
            "requiredScore" => 14
        ],
        [
            "id" => "0a3a0ffb-dc03-4aae-b207-0ed1502e60da",
            "name" => "Stealth",
            "description" => "Masters of stealth can move unseen and unheard, perfect for scouting or ambush.",
            "effect" => "Character gains advantage on stealth checks",
            "effects" => [],
            "requiredSkills" => [],
            "requiredStats" => [],
            "requiredConditions" => [],
            "requiredEffects" => [],
            "requiredScore" => 13
        ]
    ];

    public function __construct(
		$appName,
		IRequest $request,
		private readonly IAppConfig $config,
		private readonly SkillMapper $skillMapper
	)
    {
        parent::__construct($appName, $request);
    }

	/**
	 * This returns the template of the main app's page
	 * It adds some data to the template (app version)
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function page(): TemplateResponse
	{			
        return new TemplateResponse(
            //Application::APP_ID,
            'larpingapp',
            'index',
            []
        );
	}
	

    /**
     * Retrieves a list of all skills
     * 
     * This method returns a JSON response containing an array of all skills in the system.
     * It uses filters and search parameters to refine the results.
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @return JSONResponse A JSON response containing the list of skills
     */
    public function index(ObjectService $objectService, SearchService $searchService): JSONResponse
    {
        $filters = $this->request->getParams();
        $fieldsToSearch = ['name', 'description'];

        $searchParams = $searchService->createMySQLSearchParams(filters: $filters);
        $searchConditions = $searchService->createMySQLSearchConditions(filters: $filters, fieldsToSearch: $fieldsToSearch);
        $filters = $searchService->unsetSpecialQueryParams(filters: $filters);

        return new JSONResponse(['results' => $this->skillMapper->findAll(limit: null, offset: null, filters: $filters, searchConditions: $searchConditions, searchParams: $searchParams)]);
    }

    /**
     * Retrieves a single skill by its ID
     * 
     * This method returns a JSON response containing the details of a specific skill.
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param string $id The ID of the skill to retrieve
     * @return JSONResponse A JSON response containing the skill details
     */
    public function show(string $id): JSONResponse
    {
        try {
            return new JSONResponse($this->skillMapper->find(id: (int) $id));
        } catch (DoesNotExistException $exception) {
            return new JSONResponse(data: ['error' => 'Not Found'], statusCode: 404);
        }
    }

    /**
     * Creates a new skill
     * 
     * This method creates a new skill based on POST data.
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @return JSONResponse A JSON response containing the created skill
     */
    public function create(): JSONResponse
    {
        $data = $this->request->getParams();

        foreach ($data as $key => $value) {
            if (str_starts_with($key, '_')) {
                unset($data[$key]);
            }
        }
        
        return new JSONResponse($this->skillMapper->createFromArray(object: $data));
    }

    /**
     * Updates an existing skill
     * 
     * This method updates an existing skill based on its ID and the provided data.
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $id The ID of the skill to update
     * @return JSONResponse A JSON response containing the updated skill details
     */
    public function update(int $id): JSONResponse
    {
        $data = $this->request->getParams();

        foreach ($data as $key => $value) {
            if (str_starts_with($key, '_')) {
                unset($data[$key]);
            }
        }
        if (isset($data['id'])) {
            unset($data['id']);
        }
        return new JSONResponse($this->skillMapper->updateFromArray(id: (int) $id, object: $data));
    }

    /**
     * Deletes a skill
     * 
     * This method deletes a skill based on its ID.
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $id The ID of the skill to delete
     * @return JSONResponse An empty JSON response
     */
    public function destroy(int $id): JSONResponse
    {
        $this->skillMapper->delete($this->skillMapper->find((int) $id));

        return new JSONResponse([]);
    }
}
