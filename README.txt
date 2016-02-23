UPDATE NOTES 1.x -> 7.6

1. Backup old table 'tx_projectregistration_domain_model_project'
2. Move table to 'tx_projectregistration_domain_model_project_transfer'
3. Use Database analyzer (Install Tool) to apply new DB scheme
   ATTENTION: Do NOT check option 'ALTER TABLE
              tx_projectregistration_domain_model_project_transfer RENAME
              zzz_deleted_tx_projectregistration_domain_model_project_transfer;'
              as suggested by Analyzer
4. Run update script
5. Ensure all data has been transferred, static data will be stored at pid 1
   You may move them to page where plugin is installed/running
5. Use Database analyzer (Install Tool) to remove transfer table
   tx_projectregistration_domain_model_project_transfer
6. Re-Install plugin to get scheduler task imported (autoload classes)