ALTER TABLE requirement_atoms CHANGE requirement requirement ENUM('ALWAYS_TRUE','ALWAYS_FALSE','PLAYER_HAS_ITEM','PLAYER_HAS_TAGGED_ITEM','GAME_HAS_ITEM','GAME_HAS_TAGGED_ITEM','PLAYER_VIEWED_ITEM','PLAYER_VIEWED_PLAQUE','PLAYER_VIEWED_DIALOG','PLAYER_VIEWED_DIALOG_SCRIPT','PLAYER_VIEWED_WEB_PAGE','PLAYER_HAS_UPLOADED_MEDIA_ITEM','PLAYER_HAS_UPLOADED_MEDIA_ITEM_IMAGE','PLAYER_HAS_UPLOADED_MEDIA_ITEM_AUDIO','PLAYER_HAS_UPLOADED_MEDIA_ITEM_VIDEO','PLAYER_HAS_COMPLETED_QUEST','PLAYER_HAS_RECEIVED_INCOMING_WEB_HOOK','PLAYER_HAS_NOTE','PLAYER_HAS_NOTE_WITH_TAG','PLAYER_HAS_NOTE_WITH_LIKES','PLAYER_HAS_NOTE_WITH_COMMENTS','PLAYER_HAS_GIVEN_NOTE_COMMENTS') NOT NULL;