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
<link rel="stylesheet" href="/wp-content/plugins/ss-mailoptions/vendor/bower/bootstrap/dist/css/bootstrap.css"/>
<div ng-app="listApp">
	<div ng-controller="listCtrl" class="container-fluid">
		<div ng-show="model.errorsList" class="alert alert-danger">
			Не удалось сохранить свойства:
			<div ng-repeat="option in model.errorsList">
				"{{option.name}}"
			</div>
		</div>
		<div ng-show="model.isSaved" class="alert alert-success">
			Данные успешно сохранены.
		</div>
		<div class="row" ng-repeat="mail in model.mailsList">
			<div class="wrap">
				<h2>{{mail.name}}</h2>
			</div>
			<div class="row form-group">
				<div ng-repeat="option in mail.options[1]" class="form-group col-xs-12">
					<div class="col-xs-3" ng-class="{'has-error':model.errorsList[option.alias]}">
						<label class="control-label">{{option.name}}</label>
					</div>
					<div class="col-xs-9">
						<input type="checkbox" class="form-control" ng-true-value="1" ng-false-value="0"
							   ng-model="option.value" ng-change="model.setAsChanged(option)"/>
					</div>
				</div>
				<div ng-repeat="option in mail.options[0]" class="form-group col-xs-12">
					<div class="col-xs-3" ng-class="{'has-error':model.errorsList[option.alias]}">
						<label class="control-label">{{option.name}}</label>
					</div>
					<div class="col-xs-7">
						<input type="text" class="form-control" ng-model="option.value"
							   ng-change="model.setAsChanged(option)"/>

						<div class="small">{{option.comment}}</div>
					</div>
				</div>

				<div ng-repeat="option in mail.options[2]" class="form-group col-xs-12">
					<div class="col-xs-3" ng-class="{'has-error':model.errorsList[option.alias]}">
						<label class="control-label">{{option.name}}</label>
					</div>
					<div class="col-xs-7">
						<textarea ng-model="option.value" class="form-control"
								  ng-change="model.setAsChanged(option)"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div ng-show="model.errorsList" class="alert alert-danger">
			Не удалось сохранить свойства:
			<div ng-repeat="option in model.errorsList">
				"{{option.name}}"
			</div>
		</div>
		<div ng-show="model.isSaved" class="alert alert-success">
			Данные успешно сохранены.
		</div>
		<input type="button" class="form-group btn btn-primary" value="Сохранить изменения"
			   ng-disabled="!model.isChanged" ng-click="model.saveRequest()"/>

	</div>
</div>

<script type="text/javascript" src="/wp-content/plugins/ss-mailoptions/vendor/bower/angular/angular.js"></script>
<script type="text/javascript" src="/wp-content/plugins/ss-mailoptions/vendor/bower/jquery/dist/jquery.js"></script>

<style type="text/css">
	body {
		background: #F1F1F1;
	}

	div[ng-app=listApp] {
		width: 100%;
	}
</style>
<script>
	var list = {
		angularModule: null,
		angularController: null,
		init: function () {
			list.angularModule = angular.module('listApp', []);
			list.angularController = list.angularModule.controller('listCtrl', ['$scope', '$http', function ($scope, $http) {
				list.controller($scope, $http)
			}]);
		},
		controller: function ($scope, $http) {
			$scope.model = {
				isChanged: false, // сть изменения хотя бы в одном свойстве
				isSaved: false, // данные были успешно сохранены
				errorsList : false, // список ошибок, может быть объектом, если есть ошибки, или false, ошибок нет.
				mailsList: <?=json_encode($mailsList);?>,
                /**
                 * Помечает свойство как измененное
				 * @param option
                 */
				setAsChanged: function (option) {
					option.isChanged = true;
					$scope.model.isChanged = true;
				},
                /**
                 * Обработка ответа на запрос на сохранение свойств.
				 * @param response object ответ сервера
                 * @returns {boolean}
                 */
				saveResponse: function (response) {
					if (!response.ok) {
						$scope.model.errorsList = response.error;
						return false;
					}
					$scope.model.isChanged = false;
					$scope.model.isSaved = true;
					$scope.model.errorsList = false;
					return true;
				},
                /**
                 * Запрос на сохранение свойств
				 */
				saveRequest: function () {
					$scope.model.isSaved = false;
					$scope.model.errorsList = false;
					$http.post('/wp-admin/admin-ajax.php?action=ssma_save', $scope.model.mailsList).success(function (response) {
						$scope.model.saveResponse(response)
					});
				},

			};
		}
	};
	list.init();
</script>
