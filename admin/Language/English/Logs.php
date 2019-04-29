<?php

namespace Language\English;


class Logs
{
    public $LoggedOut = ":user logged out";

    public $LoggedIn = ":user logged in";

    public $CreatedUser = "Created User :userlogin";

    public $DeletedUser = "Removed User :userlogin";

    public $EditedUser = "Edited User :userlogin";

    public $createdTeaser = "Created a teaser :teaserID";

    public $changedTeaserText = "Teaser :teaserID Text From \":oldText\" was changed to \":newText\"";

    public $changedTeaserDefault = "Teaser :teaserID Type From :oldTeaserType was changed to :newTeaserType";

    public $changedTeaserCriteria = "Teaser :teaserID criteria :criteriaType was changed";

    public $changedTeaser = "Changed teasers data :teaserID";

    public $deletedTeaser = "Deleted the teaser :teaserID";

    public $clonedTeaser = "Cloned the teaser :teaserID";

    public $restoreTeaser = "Restored the teaser :teaserID";

    public $generatedStatistics = "Generated the statistics for the dates :beginDate to :finishDate";

    public $generatedDetailedStatistics = "Generated detailed statistics for the dates :beginDate to :finishDate";

    public $changedMessagePattern = "Changed the message pattern :oldMessageTest into :newMessageText";

    /*BlackList General*/

    public $addedBlacklistGeneral = "Added :qtyOfNumbers number(s) to the blacklist general";

    public $updatedBlacklistGeneral = "Updated :qtyOfNumbers number(s) to the blacklist general";

    public $deletedBlacklistGeneral = " Deleted :qtyOfNumbers number(s) from the blacklist general";

    public $deletedAllBlacklistGeneral = "Deleted all (:qtyOfNumbers) number(s) from the blacklist general";

    public $fileUploadedToBlacklistGeneral = ":filename file with :qtyOfNumbers number(s) uploaded to blacklist general";

    public $deletedSelectedBlacklistGeneral = "Deleted selected (:qtyOfNumbers) number(s) from the blacklist general";


    /*Health News Group*/

    public $addedHealthNews = ":User Added Health News  :Title ";

    public $updatedHealthNews = ":User Updated Health News ID :ID :Title";

    public $deletedHealthNews = ":User Deleted Health News  ID :ID :Title ";

    public $setStatusHealthNews = ":User Set Health News Status  ID :ID  To Status :Status";


    public $addedHealthTips = ":User Added Health Tips  :Title ";

    public $updatedHealthTips = ":User Updated Health Tips ID :ID :Title";

    public $deletedHealthTips = ":User Deleted Health Tips  ID :ID :Title ";

    public $setStatusHealthTips = ":User Set Health Tips Status  ID :ID  To Status :Status";


    public $addedDailyHealthTips = ":User Added Daily Health Tips  :Title ";

    public $updatedDailyHealthTips = ":User Updated Daily Health Tips ID :ID :Title";

    public $deletedDailyHealthTips = ":User Deleted Daily Health Tips  ID :ID :Title ";

    public $setStatusDailyHealthTips = ":User Set Daily Health Tips Status  ID :ID  To Status :Status";





}