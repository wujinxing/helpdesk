<?php

  class userProfileModel {
    public function __construct()
    { }

    public function getuserProfileBysAMAccountName($sAMAccountName) {
      $database = new Database();
      $database->query("SELECT * FROM user_profiles
                        WHERE sAMAccountName = :sAMAccountName");
      $database->bind(":sAMAccountName", $sAMAccountName);
      $result = $database->single();
      if ($database->rowCount() === 0) { return null;}
      return $result;
    }

    public function upsertUserProfile($object) {
      isset($object->id) ? $this->modifyUserProfileById($object) : $this->addUserProfile($object);
    }

    public function addUserProfile($object) {
      $database = new Database();
      $database->query("INSERT INTO user_profiles (sAMAccountName, contactName, contactEmail, contactTel, location, notify)
                        VALUES (:sAMAccountName, :contactName, :contactEmail, :contactTel, :location, :notify)
                      ");
      $database->bind(":sAMAccountName", $object->sAMAccountName);
      $database->bind(":contactName", $object->contactName);
      $database->bind(":contactEmail", $object->contactEmail);
      $database->bind(":contactTel", $object->contactTel);
      $database->bind(":location", $object->location);
      $database->bind(":notify", $object->notify);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyUserProfileById($object) {
      $database = new Database();
      $database->query("UPDATE user_profiles
                        SET user_profiles.sAMAccountName = :sAMAccountName,
                            user_profiles.contactName = :contactName,
                            user_profiles.contactEmail = :contactEmail,
                            user_profiles.contactTel = :contactTel,
                            user_profiles.location = :location,
                            user_profiles.notify = :notify
                        WHERE user_profiles.id = :id
                      ");
      $database->bind(":id", $object->id);
      $database->bind(":sAMAccountName", $object->sAMAccountName);
      $database->bind(":contactName", $object->contactName);
      $database->bind(":contactEmail", $object->contactEmail);
      $database->bind(":contactTel", $object->contactTel);
      $database->bind(":location", $object->location);
      $database->bind(":notify", $object->notify);
      $database->execute();
      return $database->lastInsertId();
    }



}
