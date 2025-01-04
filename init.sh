#!/usr/bin/env sh
set -e

if [ ! -f maple/.env.production ]; then
    cp maple/.env.example maple/.env.production

    APP_KEY=$(openssl rand -base64 32 | tr -d '\n')

    if grep -q "APP_KEY=" maple/.env.production; then
        sed -i "s/^APP_KEY=.*/APP_KEY=base64:$APP_KEY/" maple/.env.production
    else
        echo "APP_KEY=base64:$APP_KEY" >> maple/.env.production
    fi
    
    UUID1=$(uuidgen)
    
    if grep -q "OAUTH_ADMIN_CLIENT_ID=" maple/.env.production; then
        sed -i "s/^OAUTH_ADMIN_CLIENT_ID=.*/OAUTH_ADMIN_CLIENT_ID=$UUID1/" maple/.env.production
    else
        echo "OAUTH_ADMIN_CLIENT_ID=$UUID1" >> maple/.env.production
    fi

    SECRET1=$(openssl rand -hex 32)

    if grep -q "OAUTH_ADMIN_CLIENT_SECRET=" maple/.env.production; then
        sed -i "s/^OAUTH_ADMIN_CLIENT_SECRET=.*/OAUTH_ADMIN_CLIENT_SECRET=$SECRET1/" maple/.env.production
    else
        echo "OAUTH_ADMIN_CLIENT_SECRET=$SECRET1" >> maple/.env.production
    fi

    UUID2=$(uuidgen)
    
    if grep -q "OAUTH_USER_CLIENT_ID=" maple/.env.production; then
        sed -i "s/^OAUTH_USER_CLIENT_ID=.*/OAUTH_USER_CLIENT_ID=$UUID2/" maple/.env.production
    else
        echo "OAUTH_USER_CLIENT_ID=$UUID2" >> maple/.env.production
    fi

    SECRET2=$(openssl rand -hex 32)

    if grep -q "OAUTH_USER_CLIENT_SECRET=" maple/.env.production; then
        sed -i "s/^OAUTH_USER_CLIENT_SECRET=.*/OAUTH_USER_CLIENT_SECRET=$SECRET2/" maple/.env.production
    else
        echo "OAUTH_USER_CLIENT_SECRET=$SECRET2" >> maple/.env.production
    fi

    UUID3=$(uuidgen)
    
    if grep -q "OAUTH_CLIENT_ID=" maple/.env.production; then
        sed -i "s/^OAUTH_CLIENT_ID=.*/OAUTH_CLIENT_ID=$UUID3/" maple/.env.production
    else
        echo "OAUTH_CLIENT_ID=$UUID3" >> maple/.env.production
    fi
    
    echo ".env.production file has been created."
else
    echo ".env.production file already exists. No changes made."
fi
