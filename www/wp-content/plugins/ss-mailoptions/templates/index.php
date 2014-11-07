<?php
/**
 * User: Oleg Prihodko
 * Mail: shurup@e-mind.ru
 * Date: 05.11.14
 * Time: 16:33
 */

/**
 * @var array $mailsList
 */
?>
<script type="text/javascript" src="/wp-content/plugins/ss-mailoptions/vendor/bower/angular/angular.js"></script>
<script type="text/javascript" src="/wp-content/plugins/ss-mailoptions/vendor/bower/jquery/dist/jquery.js"></script>
<link rel="stylesheet" href="/wp-content/plugins/ss-mailoptions/vendor/bower/bootstrap/dist/css/bootstrap.css" />
<script>
	var list = {
		angularModule : null,
		angularController : null,
		init : function() {
			list.angularModule = angular.module('listApp',[]);
			list.angularController = list.angularModule.controller('listCtrl', ['$scope', function($scope) {list.controller($scope)}]);
		},
		controller : function($scope) {
			$scope.model = {
				mailsList : <?=json_encode($mailsList);?>
			};
			$scope.is_true = function(val) {
				return parseInt(val)==1;
			}
		}
	};
	list.init();
</script>
<div ng-app="listApp">
	<div ng-controller="listCtrl" class="container-fluid">
		<div class="row" ng-repeat="mail in model.mailsList">
			<div class="col-xs-3">
				<h4>{{mail.name}}</h4>
			</div>
			<div class="col-xs-9 row form-group">
				<div ng-repeat="option in mail.options[0]" class="form-group">
					<div class="col-xs-3">
						{{option.name}}
					</div>
					<div class="col-xs-7">
						<input type="text" class="form-control" ng-model="option.value" ng-change="option.change=1" />
					</div>
				</div>
				<div ng-repeat="option in mail.options[1]" class="form-group">
					<div class="col-xs-3">
						{{option.name}}
					</div>
					<div class="col-xs-7">
						<input type="checkbox" class="form-control" ng-true-value="1" ng-false-value="0" ng-model="option.value" ng-checked="is_true(option.value)" ng-change="option.change=1" />
					</div>
				</div>
				<div ng-repeat="option in mail.options[2]" class="form-group">
					<div class="col-xs-3">
						{{option.name}}
					</div>
					<div class="col-xs-7">
						<textarea ng-model="option.value" class="form-control"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
