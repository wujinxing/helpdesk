<?php

class adminManageLocationsController {
  public function __construct()
  {
    //load required models
    $locationModel = new locationModel();
    //create empty object to store data for template
    $templateData = new stdClass();
    $templateData->title = "Manage Locations";
    $templateData->details = "Locations available for users to select when adding a new ticket to " . CODENAME;
    $templateData->listoflocations = $locationModel->getListOfLocations();

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = (isset($_POST["button_modify_value"]) ? $_POST["button_modify_value"] : $_POST["button_value"]);
        SWITCH ($switch) {
          CASE "add":
            header('Location: /admin/location/add');
            exit;
          break;
          CASE "modify":
            header('Location: /admin/location/'.$id);
            exit;
          break;
          CASE "delete":
            // Remove location
            $locationModel->removeLocationById($id);
            // PRG Redirect
            header('Location: /admin/complete');
            exit;
          break;
        }
      }

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('adminManageLocationsView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
