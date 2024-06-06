up:
	docker compose up -d --wait
	symfony serve -d
	symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async

down:
	symfony server:stop

push: #call it with push message="my message"
	git add .
	git commit -m "${message}"
	git rebase origin main
	git push force-with-leave

.PHONY: push